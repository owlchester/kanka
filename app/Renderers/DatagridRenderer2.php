<?php

namespace App\Renderers;

use App\Renderers\Layouts\Columns\Action;
use App\Renderers\Layouts\Columns\Column;
use App\Renderers\Layouts\Columns\Checkbox;
use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Header;
use App\Renderers\Layouts\Layout;
use Illuminate\Database\Eloquent\Model;

class DatagridRenderer2
{
    /** @var Layout */
    protected $layout;

    /** @var array  */
    protected $deleteForms = [];

    /** @var bool If permissions are checked or not. If false, assume we are admin. */
    protected $permissions = true;

    public function layout($layout): self
    {
        if (is_string($layout)) {
            $layout = new $layout();
        }
        $this->layout = $layout;
        return $this;
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

        foreach ($this->layout->columns() as $key => $col) {
            $headers[] = new Header($col);
        }

        if ($this->hasActions()) {
            $headers[] = new Header([]);
        }

        return $headers;
    }

    /**
     * @param Model $data
     * @return array|Column[]
     */
    public function columns(Model $model): array
    {
        $columns = [];

        if ($this->hasBulks()) {
            $columns[] = new Checkbox($model, []);
        }
        foreach ($this->layout->columns() as $key => $col) {
            $columns[] = new Standard($model, $col);
        }
        if ($this->hasActions() && auth()->check()) {
             $action = new Action($model, $this->layout->actions(), $this->permissions);
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
        return !empty($this->layout->bulks()) && auth()->user()->isAdmin();
    }

    public function bulks(): array
    {
        return $this->layout->bulks();
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
}
