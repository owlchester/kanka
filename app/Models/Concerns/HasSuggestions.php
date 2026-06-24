<?php

namespace App\Models\Concerns;

use App\Observers\SuggestionObserver;

trait HasSuggestions
{
    public static function bootHasSuggestions()
    {
        $observer = new SuggestionObserver;
        static::saved([$observer, 'saved']);
        static::deleted([$observer, 'deleted']);
    }

    public function getSuggestions(): array
    {
        if (! property_exists($this, 'suggestions')) {
            return [];
        }

        return $this->suggestions;
    }
}
