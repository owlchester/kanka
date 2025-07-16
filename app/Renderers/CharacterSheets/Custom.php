<?php

namespace App\Renderers\CharacterSheets;

use App\Models\Attribute;
use Illuminate\Support\Str;

class Custom extends Renderer
{
    public function render(): string
    {
        $this->entityAttributes = $this->entity->allAttributes;
        $html = preg_replace_callback('`\{(.*?)\}`i', function ($matches) {
            $name = (string) $matches[1];

            return $this->attribute($name);
        }, $this->campaignPlugin->version->content);

        // Replace < and > in logical blocks
        // $html = str_replace(['&lt;', '&gt;'], ['<', '>'], $html);

        // dump($html);
        // return $html;

        // If-Else condition

        $html = preg_replace_callback('`@if\((.*?)\)(.*?)@endif`si', function ($matches) {
            return $this->ifBlock($matches);
        }, $html);

        $html = preg_replace_callback('`@if\((.*?)\)(.*?)@else(.*?)@endif`si', function ($matches) {
            return $this->ifElseBlock($matches);
        }, $html);

        $html = preg_replace_callback('`@empty\((.*?)\)(.*?)@endempty`si', function ($matches) {
            return (string) $this->emptyBlock($matches);
        }, $html);
        $html = preg_replace_callback('`@notempty\((.*?)\)(.*?)@endnotempty`si', function ($matches) {
            return (string) ! $this->emptyBlock($matches);
        }, $html);

        return $html;
    }

    protected function attribute(string $name): string
    {
        /** @var Attribute|null $attr */
        $attr = $this->entityAttributes->where('name', $name)->first();
        if (! empty($attr)) {
            if ($attr->isText()) {
                return nl2br($attr->mappedValue());
            }

            return $attr->mappedValue();
        }

        return '<i class="missing-attribute">' . $name . '</i>';
    }

    /**
     * If Else block
     */
    protected function ifElseBlock(array $matches)
    {
        // Test on a missing attribute always returns false
        $trimmed = mb_trim($matches[1]);
        if (Str::contains($trimmed, '<i class="missing-attribute">')) {
            return $matches[3];
        }

        // Strip tags to remove html brs on multilines
        $condition = strip_tags(mb_trim($matches[1]));
        if (Str::contains($condition, ['=', '>', '<'])) {
            if ($this->evaluateCondition($condition)) {
                return $matches[2];
            }

            return null;
        }
        if (! empty($condition)) {
            return $matches[2];
        } else {
            return $matches[3];
        }
    }

    /**
     * If block
     *
     * @return mixed|null
     */
    protected function ifBlock(array $matches)
    {
        // If there is an else in the block, let the if-else block handle it later
        if (Str::contains($matches[2], '@else')) {
            return $matches[0];
        }
        // Test on a missing attribute always returns false
        $trimmed = mb_trim($matches[1]);
        if (Str::contains($trimmed, '<i class="missing-attribute">')) {
            return null;
        }

        // Strip tags to remove html brs on multilines
        $condition = strip_tags(mb_trim($matches[1]));
        if (Str::contains($condition, ['=', '>', '<', '&lt;', '&gt;'])) {
            if ($this->evaluateCondition($condition)) {
                return $matches[2];
            }

            return null;
        }
        if (! empty($condition)) {
            return $matches[2];
        }

        return null;
    }

    /**
     * Evaluate a condition
     */
    protected function evaluateCondition(string $condition): bool
    {
        // >=
        if (Str::contains($condition, '&gt;=')) {
            $segments = explode('&gt;=', $condition);

            return (int) mb_trim($segments[0]) >= (int) mb_trim($segments[1]);
        } elseif (Str::contains($condition, '&lt;=')) {
            $segments = explode('&lt;=', $condition);

            return (int) mb_trim($segments[0]) <= (int) mb_trim($segments[1]);
        } elseif (Str::contains($condition, '&gt;')) {
            $segments = explode('&gt;', $condition);

            return (int) mb_trim($segments[0]) > (int) mb_trim($segments[1]);
        } elseif (Str::contains($condition, '&lt;')) {
            $segments = explode('&lt;', $condition);

            return (int) mb_trim($segments[0]) < (int) mb_trim($segments[1]);
        } elseif (Str::contains($condition, '=')) {
            $segments = explode('=', $condition);

            return mb_trim($segments[0]) == mb_trim($segments[1]);
        }

        return false;
    }

    protected function emptyBlock(array $matches)
    {
        $condition = mb_trim($matches[1]);
        if (Str::contains($condition, '<i class="missing">')) {
            return false;
        }

        return ! (empty($condition));
    }
}
