<?php

namespace App\Renderers;

use App\Facades\CampaignLocalization;
use App\Renderers\Layouts\Columns\Action;
use App\Renderers\Layouts\Columns\Column;
use App\Renderers\Layouts\Columns\Checkbox;
use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Header;
use App\Renderers\Layouts\Layout;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;
use Closure;

class DatagridRenderer2
{
    /** @var Layout */
    protected $layout;

    /** @var array  */
    protected $deleteForms = [];

    /** @var array Action params for the edit/delete */
    protected $actionParams = [];

    /** @var bool If permissions are checked or not. If false, assume we are admin. */
    protected $permissions = true;

    protected $routeName = null;
    protected $routeOptions = [];

    /** @var bool|array */
    protected $bulks = false;

    /** @var \App\Models\Campaign */
    protected $campaign;

    protected Closure $highlight;

    public function __construct()
    {
        $this->campaign = CampaignLocalization::getCampaign();
    }

    /**
     * @param string|Layout $layout
     * @return $this
     */
    public function layout(string|Layout $layout): self
    {
        if (is_string($layout)) {
            $layout = new $layout();
        }
        $this->layout = $layout;
        return $this;
    }

    /**
     * @param string $route
     * @param array|null $options
     * @return $this
     */
    public function route(string $route, array $options = null): self
    {
        $this->routeName = $route;
        $this->routeOptions = $options;
        return $this;
    }

    /**
     * @param array|null $options
     * @return $this
     */
    public function actionParams(array $options = null): self
    {
        $this->actionParams = $options;
        return $this;
    }

    /**
     * Set which element needs to be highlighted
     * @param callable $highlight
     * @return $this
     */
    public function highlight(Closure $highlight): self
    {
        $this->highlight = $highlight;
        return $this;
    }

    /**
     * @return array
     */
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

        if ($this->hasBulks()) {
            $headers[] = new Header('bulk');
        }

        foreach ($this->layout->visibleColumns() as $key => $col) {
            $headers[] = new Header($col);
        }

        if ($this->hasActions()) {
            $headers[] = new Header([]);
        }

        return $headers;
    }

    /**
     * @param Model $model
     * @return array|Column[]
     */
    public function columns(Model $model): array
    {
        $columns = [];

        if ($this->hasBulks()) {
            $columns[] = new Checkbox($model, []);
        }
        foreach ($this->layout->visibleColumns() as $key => $col) {
            $columns[] = new Standard($model, $col);
        }
        if ($this->hasActions() && auth()->check()) {
            $action = new Action($model, $this->layout->actions(), $this->permissions);
            $action->params($this->actionParams);
            if ($action->hasDelete()) {
                $this->deleteForms[] = $model;
            }
            $columns[] = $action;
        }

        return $columns;
    }

    /**
     * @return bool
     */
    public function hasBulks(): bool
    {
        return !empty($this->layout->bulks()) && auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * @return array
     */
    public function bulks(): array
    {
        if ($this->bulks !== false) {
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

    /**
     * @return bool
     */
    public function hasActions(): bool
    {
        return !empty($this->layout->actions());
    }

    /**
     * @return array
     */
    public function deleteForms(): array
    {
        return $this->deleteForms;
    }

    /**
     * @param bool $permissions
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

    /**
     * @return array
     */
    public function routeOptions(): array
    {
        return $this->routeOptions;
    }

    /**
     * @return array
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
        return $options;
    }

    /**
     * Allow the ajax init to have custom ordering
     * @param array $config
     * @return array
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
     * @param mixed $row
     * @return bool
     */
    public function isHighlighted(mixed $row): bool
    {
        if (!isset($this->highlight) || !$this->highlight instanceof Closure) {
            return false;
        }
        return $this->highlight->call($row);
    }
}
