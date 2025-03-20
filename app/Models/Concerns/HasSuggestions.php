<?php

namespace App\Models\Concerns;

use App\Observers\SuggestionObserver;

trait HasSuggestions
{
    public static function bootHasSuggestions()
    {
        static::observe(new SuggestionObserver);
    }

    public function getSuggestions(): array
    {
        if (! property_exists($this, 'suggestions')) {
            return [];
        }

        return $this->suggestions;
    }
}
