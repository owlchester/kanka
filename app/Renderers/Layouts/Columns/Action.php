<?php

namespace App\Renderers\Layouts\Columns;


use App\Renderers\Layouts\Layout;
use Illuminate\Database\Eloquent\Model;

class Action extends Column
{
    protected $actions = [];

    public function __construct(Model $model, array $config, bool $permissions)
    {
        parent::__construct($model, $config);

        // Validate actions?
        foreach ($this->config as $action) {
            if ($action == Layout::ACTION_EDIT) {
                if (!$permissions) {
                    $this->actions[] = $action;
                }  elseif (auth()->user()->can('update', $this->model)) {
                    $this->actions[] = $action;
                }
            }
            elseif ($action == Layout::ACTION_DELETE) {
                if (!$permissions) {
                    $this->actions[] = $action;
                } elseif (auth()->user()->can('destroy', $this->model)) {
                    $this->actions[] = $action;
                }
            } else {
                // Custom, to do?
            }
        }
    }

    public function __toString(): string
    {
        return view('layouts.datagrid.actions')
            ->with('actions', $this->actions)
            ->with('model', $this->model);
    }

    public function css(): string|null
    {
        return 'text-center table-actions';
    }

    public function hasDelete(): bool
    {
        return in_array(Layout::ACTION_DELETE, $this->actions);
    }
}
