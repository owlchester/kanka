<?php

namespace App\Renderers\Layouts\Columns;

class Checkbox extends Column
{
    public function css(): ?string
    {
        return 'w-8';
    }

    public function __toString(): string
    {
        // @phpstan-ignore-next-line
        return '<input type="checkbox" class="m-0 cursor-pointer" name="model[]" value="' . $this->model->id . '" />';
    }
}
