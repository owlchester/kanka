<?php

namespace App\Renderers;

use App\Models\Entity;
use App\Services\FilterService;
use Collective\Html\FormFacade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Collective\Html\FormFacade as Form;

class DatagridRenderer
{
    /**
     * Columns
     * @var array
     */
    protected $columns = [];

    /**
     * Data
     * @var array
     */
    protected $data = [];

    /**
     * Options
     * @var array
     */
    protected $options = [];

    /**
     * User
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected $user;

    /**
     * @var FilterService null
     */
    protected $filterService = null;

    protected $filters = null;

    protected $dateRenderer;

    /**
     * @var null
     */
    protected $nestedFilter = null;

    public function __construct(DateRenderer $dateRenderer)
    {
        $this->user = Auth::user();
        $this->dateRenderer = $dateRenderer;
    }

    /**
     * @param FilterService $filterService
     * @param array $columns
     * @param array $data
     * @param array $options
     * @return string
     */
    public function render(
        FilterService $filterService,
        $columns = [],
        $data = [],
        $options = []
    ) {
        $this->columns = $columns;
        $this->data = $data;
        $this->options = $options;

        $this->filterService = $filterService;

        $html = '<table id="' . $this->getOption('baseRoute') . '" class="table table-striped' . ($this->nestedFilter ? ' table-nested' : null). '">';
        $html .= '<thead><tr>';
        $html .= $this->renderColumns();
        $html .=  '</tr></thead>';
        $html .=  '<tbody>';
        $html .= $this->renderRows();
        $html .=  '</tbody></table>';

        return $html;
    }

    /**
     * Render the header columns
     */
    private function renderColumns()
    {
        $html = '';
        // Checkbox for delete
        $html .= '<th>' . Form::checkbox('all', 1, false, ['id' => 'datagrid-select-all']) . '</th>';

        foreach ($this->columns as $column) {
            $html .= $this->renderHeadColumn($column);
        }
        // Admin column

        $html .= '<th class="text-right">' . $this->renderFilters() . '</th>';
        return $html;
    }

    /**
     * @param $column
     */
    private function renderHeadColumn($column)
    {
        $html = null;
        $class = null;

        // Easy mode: A string. We want to return it directly since it's so easy.
        if (is_string($column)) {
            if ($column == 'name') {
                return "<th>" . $this->route($column) . "</th>\n";
            } else {
                return "<th class='hidden-xs hidden-sm'>" . $this->route($column) . "</th>\n";
            }
        }

        // Check visibility
        if (isset($column['visible']) && $column['visible'] == false) {
            return null;
        }

        if (!empty($column['type'])) {
            // We have a type so we know what to do
            $type = $column['type'];
            $class = $column['type'];
            if ($type == 'avatar') {
                $class = !empty($column['parent']) ? 'hidden-xs hidden-sm' : $class;
                $html = null;
            } elseif ($type == 'location') {
                $class .= '  hidden-xs hidden-sm';
                $html = $this->route('location.name', trans('crud.fields.location'));
            } elseif ($type == 'organisation') {
                $class .= '  hidden-xs hidden-sm';
                $html = $this->route('organisation.name', trans('crud.fields.organisation'));
            } elseif ($type == 'character') {
                $class .= '  hidden-xs hidden-sm';
                $html = $this->route(
                    'character.name',
                    !empty($column['label']) ? $column['label'] : trans('crud.fields.character')
                );
            } elseif ($type == 'entity') {
                $class .= '  hidden-xs hidden-sm';
                $html = $this->route(
                    'entity.name',
                    !empty($column['label']) ? $column['label'] : trans('crud.fields.entity')
                );
            } elseif ($type == 'is_private') {
                // Viewers can't see private
                if (!$this->user || !$this->user->isAdmin()) {
                    return null;
                }
                $html = $this->route(
                    'is_private',
                    '<i class="fa fa-lock" title="' . trans('crud.fields.is_private') . '"></i>'
                );
            } elseif ($type == 'calendar_date') {
                $class .= ' hidden-xs hidden-sm';
                $html = $this->route('calendar_date', __('crud.fields.calendar_date'));
            } else {
                // No idea what is expected
                $html = null;
            }
        } else {
            // Now the 'fun' starts
            $class .= '  hidden-xs hidden-sm';
            if (!empty($column['label'])) {
                $label = $column['label'];

                // We have a label, that's nice. If we have a custom render, we probably can't orderBy
                if (!empty($column['disableSort'])) {
                    $html = $label;
                } else {
                    // So we have a label and no renderer, so we can order by. We just need a field
                    $html = $this->route($column['field'], $label);
                }
            } else {
                // No label? Sure, we can do this
                $html = null;
            }
        }

        return "<th" . (!empty($class) ? " class=\"$class\"" : null) . ">$html</th>\n";
    }

    /**
     * @param $label
     * @param null $field
     * @param array $options
     * @return string
     */
    private function route($field = null, $label = null, $options = [])
    {
        // Field is label
        if (empty($label)) {
            $label = $this->trans($field);
        }

        // If we are in public mode (bots) don't make this links
        if (!auth()->check()) {
            return $label;
        }

        $routeOptions = [
            'order' => $field ,
            'page' => request()->get('page')
        ];
        if (request()->get('_from', false) == 'quicklink') {
            $routeOptions['_from'] = 'quicklink';
        }

        if (!empty($this->nestedFilter)) {
            $val = request()->get($this->nestedFilter, null);
            if (!empty($val)) {
                $routeOptions[$this->nestedFilter] = $val;
            }
        }

        // Order by
        $order = $this->filterService->order();
        $orderImg = ' <i class="fa fa-sort"></i>';
        if (!empty($order) && isset($order[$field])) {
            $direction = 'down';
            if ($order[$field] != 'DESC') {
                $routeOptions['desc'] = true;
                $direction = 'up';
            }
            $orderImg = ' <i class="fa fa-sort-' . $direction . '"></i>';
        }

        return "<a href='" .
            url()->route($this->getOption('route'), $routeOptions). "'>" . $label . $orderImg . "</a>";
    }

    /**
     *
     */
    private function renderRows()
    {
        $html = '';
        $rows = 0;
        foreach ($this->data as $model) {
            $rows++;
            $html .= $this->renderRow($model);
        }

        // Render an empty row
        if ($rows == 0) {
            $html .= '<tr><td colspan="' . (count($this->columns)+2) . '"><i>'
                . __('crud.datagrid.empty') . '</i></td>';
        }
        return $html;
    }

    /**
     * @param Model $model
     */
    private function renderRow(Model $model)
    {
        $useEntity = $this->getOption('disableEntity') !== true;
        // Should never happen...
        if ($useEntity && empty($model->entity)) {
            $model->save();
            $model->refresh();
        }

        $html = '<tr data-id="' . $model->id . '" '
            . ($useEntity ? 'data-entity-id="' . $model->entity->id . '"' : null);
        if (!empty($this->options['row']) && !empty($this->options['row']['data'])) {
            foreach ($this->options['row']['data'] as $name => $data) {
                $html .= ' ' . $name . '="' . $data($model) . '"';
            }
        }
        $html .= '>';

        // Delete
        $html .= '<td>' . Form::checkbox('model[]', $model->id, false) . '</td>';

        foreach ($this->columns as $column) {
            $html .= $this->renderColumn($column, $model);
        }
        $html .= $this->renderActionRow($model);

        return $html . '</tr>';
    }

    /**
     * @param $column
     * @param $model
     * @return string
     */
    private function renderColumn($column, $model)
    {
        $class = null;
        $content = null;

        // Easy mode: String. Just return it, no need to make it complicated.
        if (is_string($column)) {
            // Just for name, a link to the view
            if ($column == 'name') {
                $route = route($this->getOption('baseRoute') . '.show', [$model]);
                $content = $model->tooltipedLink();
            } else {
                // Handle boolean values (has, is)
                if ($this->isBoolean($column)) {
                    $icon = $column == 'is_dead' ? 'ra ra-skull' : 'fa fa-check-circle';
                    $content = $model->{$column} ? '<i class="' . $icon . '"></i>' : '';
                } else {
                    $content = e($model->{$column});
                }
                $class = 'hidden-xs hidden-sm';
            }
            return '<td' . (!empty($class) ? ' class="' . $class . '"' : null) . '>' . $content . '</td>';
        }

        // Check visibility
        if (isset($column['visible']) && $column['visible'] == false) {
            return null;
        }

        // Start with a pre-defined "type"
        if (!empty($column['type'])) {
            $type = $column['type'];
            if ($type == 'avatar') {
                $who = !empty($column['parent']) ? $model->{$column['parent']} : $model;
                if ($who instanceof Entity) {
                    $who = $who->child;
                }
                $class = !empty($column['parent']) ? 'hidden-xs hidden-sm' : $class;
                if (!empty($who)) {
                    $whoRoute = !empty($column['parent_route'])
                        ? (is_string($column['parent_route'])
                            ? $column['parent_route']
                            : $column['parent_route']($model))
                        : $this->getOption('baseRoute');
                    $route = route($whoRoute . '.show', [$who]);
                    $content = '<a class="entity-image" style="background-image: url(\'' . $who->getImageUrl(40) .
                        '\');" title="' . e($who->name) . '" href="' . $route . '"></a>';
                }
            } elseif ($type == 'location') {
                $class = 'hidden-xs hidden-sm';
                if ($model->location) {
                    $content = $model->location->tooltipedLink();
                } elseif ($model->parentLocation) {
                    $content = $model->parentLocation->tooltipedLink();
                }
            } elseif ($type == 'character') {
                $class = 'hidden-xs hidden-sm';
                if ($model->character) {
                    $content = $model->character->tooltipedLink();
                }
            } elseif ($type == 'organisation') {
                $class = 'hidden-xs hidden-sm';
                if ($model->organisation) {
                    $content = $model->organisation->tooltipedLink();
                }
            } elseif ($type == 'entity') {
                $class = 'hidden-xs hidden-sm';
                if ($model->entity) {
                    $content = $model->entity->tooltipedLink();
                }
            } elseif ($type == 'is_private') {
                // Viewer can't see private
                if (!$this->user || !$this->user->isAdmin()) {
                    return null;
                }
                $content = $model->is_private ?
                    '<i class="fa fa-lock" title="' . trans('crud.is_private') . '"></i>' :
                    '<br />';
            } elseif ($type == 'calendar_date') {
                $class = 'hidden-xs hidden-sm';
                if ($model->hasCalendar()) {
                    $content = $this->dateRenderer->render($model->getDate());
                }
            } else {
                // Exception
                $content = 'ERR_UNKNOWN_TYPE';
            }
        } elseif (!empty($column['render'])) {
            // If it's not a type, do we have a renderer?
            $content = $column['render']($model, $column);
            $class = 'hidden-xs hidden-sm';
        } elseif (!empty($column['field'])) {
            // A field was given? This could be when a field needs another label than anticipated.
            $content = $model->{$column['field']};
            $class = 'hidden-xs hidden-sm';
        } else {
            // I have no idea.
            $content = 'ERR_UNKNOWN';
        }

        return '<td' . (!empty($class) ? ' class="' . $class . '"' : null) . '>' . $content . '</td>';
    }

    /**
     * @param $option
     * @return mixed|null
     */
    private function getOption($option)
    {
        if (!empty($this->options[$option])) {
            return $this->options[$option];
        }
        return null;
    }

    /**
     * @param string $field
     * @return array|\Illuminate\Contracts\Translation\Translator|null|string
     */
    private function trans($field = '')
    {
        $trans = $this->getOption('trans');
        if (!empty($trans)) {
            return trans(rtrim($trans, '.') . '.' . $field);
        }
        // No idea what to do!
        return $field;
    }

    private function renderActionRow(Model $model)
    {
        $content = '
        <a href="' . route($this->getOption('baseRoute') . '.show', [$model]) .
            '" title="' . trans('crud.view') . '">
            <i class="fa fa-eye" aria-hidden="true"></i>
        </a>';

        if ($this->user && $this->user->can('update', $model)) {
            $content .= ' <a href="'
                . route($this->getOption('baseRoute') . '.edit', [$model])
                . '" title="' . trans('crud.edit') . '">
                <i class="fa fa-edit" aria-hidden="true"></i>
            </a>';
        }

        return '<td class="text-right table-actions">' . $content . '</td>';
    }

    /**
     * Determin if a column is a boolean column
     * @param $column
     * @return bool
     */
    private function isBoolean($column)
    {
        return substr($column, 0, 3) == 'is_' || substr($column, 0, 4) == 'has_';
    }

    /**
     * Set the filters
     */
    public function filters($filters)
    {
        $this->filters = $filters;
        return $this;
    }

    /**
     * Render the filter
     * @return string
     */
    protected function renderFilters()
    {
        return '';

        if (empty($this->filters)) {
            return '';
        }

        $filtersHtml = view('cruds._filters2')->with([
            'filters' => $this->filters,
            'filterService' => $this->filterService,
            'route' => $this->getOption('route'),
            'name' => $this->getOption('trans')
        ]);


        $filtersHtml = str_replace("&#039;", '&lsquo;', $filtersHtml);
        $filtersHtml = str_replace('"', '\'', $filtersHtml);
        $activeFilters = $this->filterService->activeFilters();

        $route = route('helpers.filters');
        $html = '
        <div class="table-filters" title="' . __('crud.filters.title') . '
            <a href=\'' . $route . '\' class=\'pull-right\' target=\'_blank\' title=\'' . __('helpers.filters.title') .'\'>
                <i class=\'fa fa-question-circle\'></i>
            </a>
        " data-toggle="popover" '
            . 'data-html="true" data-placement="left" data-content="' . $filtersHtml . '">
            <i class="fa fa-filter"></i>
            ' . (!empty($activeFilters) ? '<span class="label label-danger">' . count($activeFilters) . '</span>' : null) . '
            <i class="fa fa-caret-down"></i>
        </div>';


        return $html;
    }

    /**
     * Tell the rendered that this is a nested view
     * @param string $key
     * @return $this
     */
    public function nested($key = 'parent_id')
    {
        $this->nestedFilter = $key;
        return $this;
    }
}
