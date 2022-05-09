<?php

namespace App\Renderers\Layouts\Columns;

class Checkbox extends Column
{
    public function __toString(): string
    {
        return '<input type="checkbox" name="model[]" value="' . $this->model->id . '" />';
    }
}
