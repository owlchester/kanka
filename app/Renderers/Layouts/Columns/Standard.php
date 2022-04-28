<?php

namespace App\Renderers\Layouts\Columns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Standard extends Column
{
    const CHARACTER = 'character';
    const IMAGE = 'image';
    const ENTITYLINK = 'entitylink';

    public function __toString(): string
    {
        if (!isset($this->config['render'])) {
            return (string) $this->model->{$this->config['key']};
        }

        $render = $this->config['render'];
        if (is_callable($render)) {
            return (string) $render($this->model);
        }

        elseif ($this->defined($render)) {
            return $this->view($render, Arr::get($this->config, 'with'));
        }

        $method = substr($render, 0, -2);
        if (Str::endsWith($render, '()') && method_exists($this->model, $method)) {
            return (string) $this->model->$method();
        }
        return $render . '???';
    }

    /**
     * If this is a defined view
     * @param string $render
     * @return bool
     */
    protected function defined(string $render): bool
    {
        return in_array($render, [
            self::CHARACTER,
            self::IMAGE,
            self::ENTITYLINK
        ]);
    }
    /**
     * Render a defined view
     * @return string
     */
    protected function view(string $view, array $extra = null): string
    {
        return view('layouts.datagrid.rows.' . $view)
            ->with('model', $this->model)
            ->with('with', $extra)
            ->render();
    }

}
