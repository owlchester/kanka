<?php

namespace App\Models\Concerns;

use App\Observers\SuggestionObserver;

trait HasSuggestions
{
    public static function bootHasSuggestions(): void
    {
        $observer = new SuggestionObserver;
        static::saved([$observer, 'saved']);
        static::deleted([$observer, 'deleted']);
    }
}
