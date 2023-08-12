<?php

namespace App\Renderers\Layouts\Columns;

use App\Renderers\Layouts\Layout;
use App\Traits\CampaignAware;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Action extends Column
{
    use CampaignAware;

    /** @var array Available actions to render */
    protected $actions = [];

    /** @var array Params passed to the individual action routes, ie ['from' => 'calendar'] for workflow */
    protected $params = [];

    /**
     * @param Model $model
     * @param array $config
     * @param bool $permissions
     */
    public function __construct(Model $model, array $config, bool $permissions)
    {
        parent::__construct($model, $config);

        // Validate actions?
        foreach ($this->config as $action) {
            if (in_array($action, [Layout::ACTION_EDIT, Layout::ACTION_EDIT_AJAX, Layout::ACTION_COPY])) {
                if (!$permissions) {
                    $this->actions[] = $action;
                } elseif (auth()->user()->can('update', $this->model)) {
                    $this->actions[] = $action;
                }
            } elseif ($action == Layout::ACTION_DELETE) {
                if (!$permissions) {
                    $this->actions[] = $action;
                } elseif (auth()->user()->can('delete', $this->model)) {
                    $this->actions[] = $action;
                }
            } elseif (is_array($action)) {
                // Custom, to do?
                $this->import($action);
            }
        }
    }

    /**
     * @param array $params
     * @return $this
     */
    public function params(array $params): self
    {
        $this->params = $params;
        return $this;
    }

    public function __toString(): string
    {
        $html = view('layouts.datagrid.actions')
            ->with('actions', $this->actions)
            ->with('model', $this->model)
            ->with('params', $this->params)
            ->with('campaign', $this->campaign)
            ->render()
        ;
        return $html;
    }

    public function css(): string|null
    {
        return 'text-center table-actions';
    }

    public function hasDelete(): bool
    {
        return in_array(Layout::ACTION_DELETE, $this->actions);
    }

    /**
     * @param array $action
     * @return $this
     */
    protected function import(array $action): self
    {
        // No auth check? We good.
        if (!Arr::has($action, 'can')) {
            $this->actions[] = $action;
            return $this;
        }

        if (auth()->user()->can($action['can'], $this->model)) {
            $this->actions[] = $action;
        }
        return $this;
    }
}
