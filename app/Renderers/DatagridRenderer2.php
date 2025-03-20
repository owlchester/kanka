<?php

namespace App\Renderers;

use App\Models\Entity;
use App\Renderers\Layouts\Columns\Action;
use App\Renderers\Layouts\Columns\Checkbox;
use App\Renderers\Layouts\Columns\Column;
use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Header;
use App\Renderers\Layouts\Layout;
use App\Traits\CampaignAware;
use App\Traits\EntityTypeAware;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;
use UnitEnum;

class DatagridRenderer2
{
    use CampaignAware;
    use EntityTypeAware;

    protected Layout $layout;

    protected array $deleteForms = [];

    /** Action params for the edit/delete */
    protected array $actionParams = [];

    /** If permissions are checked or not. If false, assume we are admin. */
    protected bool $permissions = true;

    protected $routeName = null;

    protected array $routeOptions = [];

    protected array $bulks;

    protected Closure $highlight;

    public function layout(string|Layout $layout): self
    {
        if (is_string($layout)) {
            $layout = new $layout;
        }
        $this->layout = $layout;

        return $this;
    }

    public function route(string $route, ?array $options = null): self
    {
        $this->routeName = $route;
        $this->routeOptions = $options;

        return $this;
    }

    public function actionParams(?array $options = null): self
    {
        $this->actionParams = $options;

        return $this;
    }

    /**
     * Set which element needs to be highlighted
     */
    public function highlight(Closure $highlight): self
    {
        $this->highlight = $highlight;

        return $this;
    }

    public function getActionParams(): array
    {
        return $this->actionParams;
    }

    /**
     * @return Header[]
     */
    public function headers(): array
    {
        $headers = [];

        $header = null;
        if ($this->hasBulks()) {
            $headers[] = (new Header('bulk'))->campaign($this->campaign);
        }

        foreach ($this->layout->visibleColumns() as $key => $col) {
            $headers[] = (new Header($col))->campaign($this->campaign);
        }

        if ($this->hasActions()) {
            $headers[] = (new Header([]))->campaign($this->campaign);
        }

        return $headers;
    }

    /**
     * @return array|Column[]
     */
    public function columns(Model $model): array
    {
        $columns = [];

        if ($this->hasBulks()) {
            $columns[] = (new Checkbox($model, []))->campaign($this->campaign);
        }
        foreach ($this->layout->visibleColumns() as $key => $col) {
            $columns[] = (new Standard($model, $col))->campaign($this->campaign);
        }
        if ($this->hasActions() && auth()->check()) {
            $action = new Action($model, $this->layout->actions(), $this->permissions);
            $action->params($this->actionParams);
            $action->campaign($this->campaign);
            if ($action->hasDelete()) {
                $this->deleteForms[] = $model;
            }
            $columns[] = $action;
        }

        return $columns;
    }

    public function hasBulks(): bool
    {
        return ! empty($this->layout->bulks()) && auth()->check() && auth()->user()->isAdmin();
    }

    public function bulks(): array
    {
        if (isset($this->bulks)) {
            return $this->bulks;
        }

        $this->bulks = [];
        $bulks = $this->layout->bulks();
        foreach ($bulks as $bulk) {
            if (is_array($bulk)) {
                if (empty($bulk['can'])) {
                    $this->bulks[] = $bulk;

                    continue;
                }
                $can = $bulk['can'];
                // General campaign permission
                if (Str::startsWith($can, 'campaign:')) {
                    $action = Str::afterLast($can, 'campaign:');

                    if (auth()->check() && auth()->user()->can($action, $this->campaign)) {
                        $this->bulks[] = $bulk;
                    }

                    continue;
                }
                // More specific use cases?
            } elseif ($bulk === Layout::ACTION_DELETE) {
                if (auth()->check() && auth()->user()->isAdmin()) {
                    $this->bulks[] = $bulk;
                }
            } elseif ($bulk === Layout::ACTION_EDIT) {
                $this->bulks[] = $bulk;
            }
        }

        return $this->bulks;
    }

    public function hasActions(): bool
    {
        return ! empty($this->layout->actions());
    }

    public function deleteForms(): array
    {
        return $this->deleteForms;
    }

    /**
     * @return $this
     */
    public function permissions(bool $permissions): self
    {
        $this->permissions = $permissions;

        return $this;
    }

    /**
     * @return string|null
     */
    public function routeName()
    {
        if (isset($this->routeName)) {
            return $this->routeName;
        }

        /** @var Route $route */
        $route = request()->route();

        return $route->getName();
    }

    public function routeOptions(): array
    {
        return $this->routeOptions;
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function paginationFilters(): array
    {
        $options = $this->routeOptions;
        foreach ($this->routeOptions as $k => $v) {
            if (Str::endsWith($k, '_id')) {
                continue;
            } elseif ($k === 'all') {
                continue;
            }
            unset($options[$k]);
        }
        if (request()->has('o')) {
            $options['o'] = request()->get('o');
        }
        if (request()->has('k')) {
            $options['k'] = request()->get('k');
        }
        if (request()->has('m')) {
            $options['m'] = request()->get('m');
        }

        return $options;
    }

    /**
     * Allow the ajax init to have custom ordering
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function initOptions(array $config): array
    {
        if (request()->has('o')) {
            $config['o'] = request()->get('o');
        }
        if (request()->has('k')) {
            $config['k'] = request()->get('k');
        }

        return $config;
    }

    /**
     * Highlight a row if it matches the highlight closure
     */
    public function isHighlighted(mixed $row): bool
    {
        if (! isset($this->highlight) || ! $this->highlight instanceof Closure) {
            return false;
        }

        return $this->highlight->call($row);
    }

    /**
     * Create a list of data-attributes from the row for the row
     */
    public function rowAttributes(mixed $row): string
    {
        $attributes = [];
        foreach ($row->rowAttributes() as $attr => $val) {
            if ($val instanceof UnitEnum) {
                // @phpstan-ignore-next-line
                $val = $val->value;
            }
            $attributes[] = 'data-' . $attr . '="' . $val . '"';
        }

        return implode(' ', $attributes);
    }

    protected function entityLink(Model $model): string
    {
        if ($model instanceof Entity) {
            return \Illuminate\Support\Facades\Blade::renderComponent(
                new \App\View\Components\EntityLink($model, $this->campaign)
            );
        }

        // @phpstan-ignore-next-line
        return '<a href="' . $model->getLink() . '">' . $model->name . '</a>';
    }
}
