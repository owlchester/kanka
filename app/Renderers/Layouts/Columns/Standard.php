<?php

namespace App\Renderers\Layouts\Columns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Standard extends Column
{
    public function __toString(): string
    {
        if (!isset($this->config['render'])) {
            return $this->model->{$this->config['key']};
        }

        $render = $this->config['render'];
        if (is_callable($render)) {
            return (string) $render($this->model);
        }

        $method = substr($render, 0, -2);
        if (Str::endsWith($render, '()') && method_exists($this->model, $method)) {
            return (string) $this->model->$method();
        }
        return $render . '???';
    }

}
