<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Stevebauman\Purify\Facades\Purify;

class SanitizedObserver
{
    /**
     */
    public function saving(Model $model): void
    {
        $attributes = $model->getAttributes();
        // @phpstan-ignore-next-line
        foreach ($model->getSanitizable() as $field) {
            if (Str::contains($field, '.')) {
                $segments = explode('.', $field);
                if (!isset($attributes[$segments[0]])) {
                    continue;
                }
                $array = $model->{$segments[0]};
                if (!isset($array[$segments[1]])) {
                    continue;
                }
                $array[$segments[1]] = $this->purify($model->{$segments[0]}[$segments[1]]);
                $model->{$segments[0]} = $array;
            } else {
                if (!isset($attributes[$field])) {
                    continue;
                }
                $model->$field = $this->purify($model->$field);
            }
        }
    }

    protected function purify(?string $text): ?string
    {
        $text = mb_trim(Purify::clean(strip_tags($text)) ?? '');
        // Users still want to use < and > so let's not break it for them
        //$text = Str::replace(['&lt;', '&gt;', '&amp;&amp;'], ['<', '>', '&&'], $text);
        // If it's really empty, zap it
        if ($text == "\r\n\r\n" || empty($text)) {
            return null;
        }
        return $text;
    }


}
