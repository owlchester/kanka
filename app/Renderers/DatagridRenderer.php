<?php

namespace App\Renderers;

use App\Facades\Avatar;
use App\Facades\Module;
use App\Models\Bookmark;
use App\Models\Entity;
use App\Models\Journal;
use App\Models\Location;
use App\Models\MiscModel;
use App\Services\FilterService;
use App\Traits\CampaignAware;
use App\Traits\EntityTypeAware;
use App\Traits\RequestAware;
use App\Traits\UserAware;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;

class DatagridRenderer
{
    use CampaignAware;
    use EntityTypeAware;
    use RequestAware;
    use UserAware;

    protected string $hidden = ' hidden lg:table-cell';

    protected array $columns = [];

    protected Bookmark $bookmark;

    protected LengthAwarePaginator|Collection|array $data = [];

    protected array $options = [];

    protected Collection|LengthAwarePaginator|array $models;

    protected ?FilterService $filterService = null;

    protected ?string $nestedFilter = null;

    protected bool $showAds;

    public function __construct() {}

    public function columns(array $columns): self
    {
        $this->columns = $columns;

        return $this;
    }

    public function options(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function bookmark(Bookmark $bookmark): self
    {
        $this->bookmark = $bookmark;

        return $this;
    }

    public function models(Collection|LengthAwarePaginator $models): self
    {
        $this->models = $models;

        return $this;
    }

    public function service($service): self
    {
        $this->filterService = $service;

        return $this;
    }

    /**
     * @param  array  $columns
     * @param  array  $data
     * @param  array  $options
     */
    public function render(
        FilterService $filterService,
        $columns = [],
        $data = [],
        $options = []
    ): self {
        $this->columns = $columns;
        $this->models = $data;
        $this->options = $options;

        $this->filterService = $filterService;

        return $this;
    }

    public function __toString(): string
    {
        $html = '<table id="' . $this->getOption('baseRoute') . '" class="table table-striped table-entities mb-0' .
            ($this->nestedFilter ? ' table-nested' : null) . '">';
        $html .= '<thead><tr>';
        $html .= $this->renderColumns();
        $html .= '</tr></thead>';
        $html .= '<tbody>';
        $html .= $this->renderRows();
        $html .= '</tbody></table>';

        return $html;
    }

    /**
     * Render the header columns
     */
    private function renderColumns()
    {
        $html = '';
        // Checkbox for delete
        if (auth()->check()) {
            $html .= '<th class="col-checkbox"><input type="checkbox" name="all" value="1" id="datagrid-select-all" /></th>';
        }

        foreach ($this->columns as $column) {
            $html .= $this->renderHeadColumn($column);
        }
        // Admin column

        $html .= '<th class="text-right col-actions">' . $this->renderFilters() . '</th>';

        return $html;
    }

    /**
     * @param  string|array  $column
     */
    private function renderHeadColumn($column)
    {
        // Easy mode: A string. We want to return it directly since it's so easy.
        if (is_string($column)) {
            if ($column == 'name') {
                return "<th class='dg-name'>" . $this->route($column) . "</th>\n";
            } else {
                return "<th class='dg-" . $column . ' ' . $this->hidden . "'>" . $this->route($column) . "</th>\n";
            }
        }

        // Check visibility
        if (isset($column['visible']) && $column['visible'] == false) {
            return null;
        }

        $html = null;
        $class = null;

        if (! empty($column['type'])) {
            // We have a type so we know what to do
            $type = $column['type'];
            $class = $column['type'];
            if ($type == 'avatar') {
                $class = (! empty($column['parent']) ? $this->hidden : $class) . ' w-14';
            } elseif ($type == 'location') {
                $class .= ' ' . $this->hidden;
                $label = Arr::get($column, 'label', Module::singular(config('entities.ids.location'), __('entities.location')));
                $html = $this->route('location.name', $label);
            } elseif ($type == 'entityLocations') {
                $class .= ' ' . $this->hidden;
                $label = Arr::get($column, 'label', Module::plural(config('entities.ids.location'), __('entities.locations')));
                $html = $this->route('locations', $label);
            } elseif ($type == 'organisation') {
                $class .= ' ' . $this->hidden;
                $label = Arr::get($column, 'label', Module::singular(config('entities.ids.organisation'), __('entities.organisation')));
                $html = $this->route('organisation.name', $label);
            } elseif ($type == 'character') {
                $class .= ' ' . $this->hidden;
                $label = Arr::get($column, 'label', Module::singular(config('entities.ids.character'), __('entities.character')));
                $html = $this->route(
                    'character.name',
                    $label
                );
            } elseif ($type == 'entity') {
                $class .= ' ' . $this->hidden;
                $html = $this->route(
                    'entity.name',
                    ! empty($column['label']) ? $column['label'] : __('crud.fields.entity')
                );
            } elseif ($type == 'parent') {
                $class .= ' ' . $this->hidden;
                if (! empty($this->nestedFilter)) {
                    return null;
                }
                $html = $this->route(
                    Arr::get($column, 'field', 'parent.name'),
                    ! empty($column['label']) ? $column['label'] : __('crud.fields.parent')
                );
            } elseif ($type == 'is_private') {
                // Viewers can't see private
                if (! isset($this->user) || ! $this->user->isAdmin()) {
                    return null;
                }
                $html = $this->route(
                    'is_private',
                    '<i class="fa-regular fa-lock" data-title="' . __('crud.fields.is_private') . '" aria-hidden="true" data-toggle="tooltip"></i> <span class="sr-only">' . __('crud.fields.is_private') . '</span>'
                );
                $class = 'w-14 text-center';
            } elseif ($type == 'reminder') {
                $class .= ' ' . $this->hidden;
                $html = $this->route('calendar_date', __('crud.fields.calendar_date'));
            } else {
                // No idea what is expected
                $html = null;
            }
        } else {
            // Now the 'fun' starts
            $class .= Arr::get($column, 'class', ' ' . $this->hidden);
            if (! empty($column['label'])) {
                $label = $column['label'];

                // We have a label, that's nice. If we have a custom render, we probably can't orderBy
                if (! empty($column['disableSort'])) {
                    $html = $label;
                } else {
                    // So we have a label and no renderer, so we can order by. We just need a field
                    $html = $this->route($column['field'], $label);
                }
                if (Str::contains($label, '<i')) {
                    $type = $column['field'] ?? '';
                } else {
                    $type = Str::slug($label);
                }
            } else {
                // No label? Sure, we can do this
                $html = null;
                $type = 'unknown';
            }
        }

        return "<th class='dg-" . $type . ' ' . ($class ?? null) . "'>{$html}</th>\n";
    }

    private function route(?string $field = null, ?string $label = null): string
    {
        // Field is label
        if (empty($label)) {
            $label = $this->trans($field);
        }

        // If we are in public mode (bots) don't make this links
        if (! auth()->check()) {
            return $label;
        }

        $routeOptions = [
            'campaign' => $this->campaign,
            'order' => $field,
            'page' => $this->request->get('page'),
        ];

        if (isset($this->bookmark)) {
            $routeOptions['bookmark'] = $this->bookmark;
        }

        if ($this->request->get('_from', false) == 'bookmark') {
            $routeOptions['_from'] = 'bookmark';
        }

        if (! empty($this->nestedFilter)) {
            $val = $this->request->get($this->nestedFilter, null);
            if (! empty($val)) {
                $routeOptions[$this->nestedFilter] = $val;
            }
        }

        // Order by
        $order = $this->filterService->order();
        $orderImg = ' <i class="fa-regular fa-sort" aria-hidden="true"></i>';
        if (! empty($order) && isset($order[$field])) {
            $direction = 'down';
            if ($order[$field] != 'DESC') {
                $routeOptions['desc'] = true;
                $direction = 'up';
            }
            $orderImg = ' <i class="fa-regular fa-sort-' . $direction . '" aria-hidden="true"></i>';
        }

        return "<a href='" .
            url()->route($this->getOption('route'), $routeOptions) . "' class='text-link'>" . $label . $orderImg . '</a>';
    }

    private function renderRows()
    {
        $html = '';
        $rows = 0;
        foreach ($this->models as $model) {
            $rows++;
            $html .= $this->renderRow($model);

            if ($rows % 7 === 0) {
                $html .= $this->renderAdRow($rows);
            }
        }

        // Render an empty row
        if ($rows == 0) {
            $html .= '<tr><td colspan="' . (count($this->columns) + 2) . '"><i>'
                . __('crud.datagrid.empty') . '</i></td>';
        }

        return $html;
    }

    private function renderRow(Model $model): string
    {
        /** @var MiscModel|Entity|Location $model */
        $useEntity = $this->getOption('disableEntity') !== true;
        // Should never happen...
        if ($useEntity && empty($model->entity)) {
            return '';
        }

        $html = '<tr data-id="' . $model->id . '" '
            . (! empty($model->type) ? 'data-type="' . Str::slug($model->type) . '" ' : null)
            . ($useEntity ? 'data-entity-id="' . $model->entity->id . '" data-entity-type="' . $model->entity->entityType->code . '"' : null);
        /*if (!empty($this->options['row']) && !empty($this->options['row']['data'])) {
            foreach ($this->options['row']['data'] as $name => $data) {
                $html .= ' ' . $name . '="' . $data($model) . '"';
            }
        }*/
        if (! empty($this->nestedFilter) && method_exists($model, 'children')) {
            $html .= ' data-children="' . $model->children_count . '"';
        }
        $html .= '>';

        // Bulk
        if (auth()->check()) {
            $html .= '<td class="w-8"><input type="checkbox" name="model[]" value="' . $model->id . '" /></td>';
        }

        foreach ($this->columns as $column) {
            $html .= $this->renderColumn($column, $model);
        }
        $html .= $model instanceof MiscModel ? $this->renderEntityActionRow($model) : $this->renderActionRow($model);

        return $html . '</tr>';
    }

    protected function renderAdRow(int $rows): string
    {
        if (! $this->showAds()) {
            return '';
        }

        $colspan = count($this->columns) + (auth()->check() ? 2 : 0);

        return '<tr><td class="adrow" colspan="' . $colspan . '">' .
            Blade::render('ads.table', ['campaign' => $this->campaign, 'rows' => $rows]) .
        '</td></tr>';
    }

    protected function showAds(): bool
    {
        if (isset($this->showAds)) {
            return $this->showAds;
        }
        if (! config('ads.nitro.enabled')) {
            return $this->showAds = false;
        }
        if ($this->request->has('_showads')) {
            return $this->showAds = true;
        }
        if (isset($this->user)) {
            // Subscribed users don't have ads
            if ($this->user->isSubscriber()) {
                return $this->showAds = false;
            }
            // User has been created less than 24 hours ago
            if ($this->user->created_at->diffInHours(Carbon::now()) < 24) {
                return $this->showAds = false;
            }
        }

        // Premium campaigns don't have ads displayed to their members
        return $this->showAds = ! empty($this->campaign) && ! $this->campaign->boosted();
    }

    /**
     * @param  MiscModel|Journal|Location  $model
     * @return string|null
     */
    private function renderColumn(string|array $column, $model)
    {
        $class = null;
        $content = null;

        // Easy mode: String. Just return it, no need to make it complicated.
        if (is_string($column)) {
            // Just for name, a link to the view
            if ($column == 'name') {
                $content = $this->entityLink($model);
            } elseif ($column === 'type') {
                $content = $model instanceof Entity ? $model->type : $model->entity->type;
            } else {
                // Handle boolean values (has, is)
                if ($this->isBoolean($column)) {
                    $icon = $column == 'is_dead' ? 'fa-regular fa-skull' : 'fa-regular fa-check-circle';
                    $content = $model->{$column} ? '<i class="' . $icon . '" aria-hidden="true"></i>' : '';
                } else {
                    $content = ($model->{$column});
                }
                $class = $this->hidden;
            }

            return '<td class="truncated max-w-fit' . ($class ?? null) . '">' . $content . '</td>';
        }

        // Check visibility
        if (isset($column['visible']) && $column['visible'] == false) {
            return null;
        }

        // Start with a pre-defined "type"
        if (! empty($column['type'])) {
            $type = $column['type'];
            if ($type == 'avatar') {
                $who = ! empty($column['parent']) ? $model->{$column['parent']} : $model;
                if ($who instanceof Entity) {
                    Avatar::entity($who)->child($who->child);
                    $who = $who->child;
                } else {
                    Avatar::entity($who->entity)->child($who);
                }
                $class = ! empty($column['parent']) ? $this->hidden : $class;
                if (! empty($who)) {
                    $route = $who->getLink();
                    $content = '<a class="entity-image cover-background w-10 h-10" style="background-image: url(\'' . Avatar::size(40)->fallback()->thumbnail() .
                        '\');" title="' . e($who->name) . '" href="' . $route . '"></a>';
                }
            } elseif ($type == 'location') {
                $class = $this->hidden;
                // @phpstan-ignore-next-line
                if (method_exists($model, 'location') && $model->location && $model->location->entity) {
                    $content = $this->entityLink($model->location->entity);
                }
            } elseif ($type == 'entityLocations') {
                $class = $this->hidden;
                // @phpstan-ignore-next-line
                $locations = [];
                if ($model->entity->locations->isNotEmpty()) {
                    foreach ($model->entity->locations as $location) {
                        $locations[] = $this->entityLink($location->entity);
                    }
                }
                $content = implode(', ', $locations);
            } elseif ($type == 'character') {
                $class = $this->hidden;
                // @phpstan-ignore-next-line
                if (method_exists($model, 'character') && $model->character && $model->character->entity) {
                    $content = $this->entityLink($model->character->entity);
                }
            } elseif ($type == 'organisation') {
                $class = $this->hidden;
                // @phpstan-ignore-next-line
                if (method_exists($model, 'organisation') && $model->organisation && $model->organisation->entity) {
                    $content = $this->entityLink($model->organisation->entity);
                }
            } elseif ($type == 'entity') {
                $class = $this->hidden;
                if ($model->entity) {
                    $content = $this->entityLink($model->entity);
                }
            } elseif ($type == 'parent') {
                $class = $this->hidden;
                if (! empty($this->nestedFilter)) {
                    return null;
                }
                // @phpstan-ignore-next-line
                if ($model->parent && $model->parent->entity) {
                    $content = $this->entityLink($model->parent->entity);
                }
            } elseif ($type == 'is_private') {
                // Viewer can't see private
                if (! isset($this->user) || ! $this->user->isAdmin()) {
                    return null;
                }
                $content = $model->is_private ?
                    '<i class="fa-regular fa-lock" data-title="' . __('crud.is_private') . '" aria-hidden="true" data-toggle="tooltip"></i> <span class="sr-only">' . __('crud.is_private') . '</span>' :
                    null;
                $class = ' text-center';
            } elseif ($type == 'reminder') {
                $class = $this->hidden . ' col-calendar-date';
                /** @var Journal $model */
                if ($model->entity->calendarDate && $model->entity->calendarDate->calendar && $model->entity->calendarDate->calendar->entity) {
                    $reminder = $model->entity->calendarDate;
                    $content = '<a href="' . route('entities.show', [$this->campaign, $reminder->calendar->entity, 'month' => $reminder->month, 'year' => $reminder->year]) . '" class="text-link">' . $reminder->readableDate() . '</a>';
                }
            } else {
                // Exception
                $content = 'ERR_UNKNOWN_TYPE';
            }
        } elseif (! empty($column['render'])) {
            // If it's not a type, do we have a renderer?
            $content = $column['render']($model, $column);
            $class = Arr::get($column, 'class', $this->hidden);
        } elseif (! empty($column['field'])) {
            // A field was given? This could be when a field needs another label than anticipated.
            $content = $model->{$column['field']};
            $class = $this->hidden;
        } else {
            // I have no idea.
            $content = 'ERR_UNKNOWN';
        }

        return '<td' . (! empty($class) ? ' class="' . $class . '"' : null) . '>' . $content . '</td>';
    }

    /**
     * @param  string  $option
     * @return mixed|null
     */
    private function getOption($option)
    {
        if (! empty($this->options[$option])) {
            return $this->options[$option];
        }

        return null;
    }

    /**
     * @return string
     */
    private function trans(string $field = '')
    {
        $crudFields = ['name', 'type'];
        if (in_array($field, $crudFields)) {
            return __('crud.fields.' . $field);
        }
        $trans = $this->getOption('trans');
        if (! empty($trans)) {
            return __(mb_rtrim($trans, '.') . '.' . $field);
        }

        // No idea what to do!
        return $field;
    }

    private function renderEntityActionRow(MiscModel $model): string
    {
        $content = '';
        $actions = $model->datagridActions($this->campaign);
        if (! empty($actions)) {
            $content = Blade::render('cruds.datagrids._row-actions', ['campaign' => $this->campaign, 'model' => $model, 'actions' => $actions]);
        }

        return '<td class="text-center table-actions w-14">' . $content . '</td>';
    }

    private function renderActionRow($model): string
    {
        $actions = '';
        if (isset($this->user) && $this->user->can('update', $model)) {
            $actions .= ' <a href="'
                . route($this->getOption('baseRoute') . '.edit', [$this->campaign, $model])
                . '" title="' . __('crud.edit') . '" class="text-link">
                <i class="fa-regular fa-edit" aria-hidden="true"></i>
            </a>';
        }

        return '<td class="text-center table-actions">' . $actions . '</td>';
    }

    /**
     * Determin if a column is a boolean column
     *
     * @return bool
     */
    private function isBoolean(string $column)
    {
        return Str::startsWith($column, ['is_', 'has_']);
    }

    /**
     * Render the filter
     *
     * @return string
     */
    protected function renderFilters()
    {
        return '';
    }

    /**
     * Tell the rendered that this is a nested view
     */
    public function nested(string $key = 'parent_id'): self
    {
        $this->nestedFilter = $key;

        return $this;
    }

    protected function entityLink(Model $model): string
    {
        if ($model instanceof Entity) {
            return Blade::renderComponent(
                new \App\View\Components\EntityLink($model, $this->campaign)
            );
        } elseif ($model->entity) {// @phpstan-ignore-line
            return Blade::renderComponent(
                new \App\View\Components\EntityLink($model->entity, $this->campaign)
            );
        }

        // @phpstan-ignore-next-line
        return '<a href="' . $model->getLink() . '" class="text-link">' . $model->name . '</a>';
    }
}
