<?php

namespace App\Renderers\Layouts\Columns;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Standard extends Column
{
    public const CHARACTER = 'character';

    public const IMAGE = 'image';

    public const ENTITYLINK = 'entitylink';

    public const ENTITYLIST = 'entitylist';

    public const ParentLink = 'parentlink';

    public const VIEW = 'view';

    public const LOCATION = 'location';

    public const MENTION_LINK = 'mention-link';

    public const VISIBILITY = 'visibility';

    public const VISIBILITY_PIVOT = 'visibility_pivot';

    public const DATE = 'date';

    public const TAGS = 'tags';
    public const SINCE = 'since';

    public function __toString(): string
    {
        if (! isset($this->config['render']) && isset($this->config['renter'])) {
            return 'Misspelled _render_';
        }
        if (! isset($this->config['render'])) {
            return (string) $this->model->{$this->config['key']};
        }

        $render = $this->config['render'];
        if ($render instanceof Closure) {
            return (string) $render($this->model);
        } elseif ($this->defined($render)) {
            return $this->view($render, Arr::get($this->config, 'with'));
        }

        $method = mb_substr($render, 0, -2);
        if (Str::endsWith($render, '()') && method_exists($this->model, $method)) {
            return (string) $this->model->$method();
        }

        return $render . '???';
    }

    /**
     * If this is a defined view
     */
    protected function defined(string $render): bool
    {
        return in_array($render, [
            self::CHARACTER,
            self::IMAGE,
            self::TAGS,
            self::ENTITYLINK,
            self::LOCATION,
            self::ENTITYLIST,
            self::ParentLink,
            self::VISIBILITY,
            self::VISIBILITY_PIVOT,
            self::DATE,
            self::MENTION_LINK,
            self::VIEW,
            self::SINCE,
        ]);
    }

    /**
     * Render a defined view
     */
    protected function view(string $view, mixed $extra = null): string
    {
        return view('layouts.datagrid.rows.' . $view)
            ->with('model', $this->model)
            ->with('with', $extra)
            ->with('key', $this->config['key'] ?? '')
            ->with('campaign', $this->campaign)
            ->render();
    }
}
