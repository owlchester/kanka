<?php

namespace App\Observers;

use App\Facades\EntityCache;
use App\Models\MiscModel;
use Illuminate\Database\Eloquent\Model;

class SuggestionObserver
{
    public function saved(Model $model)
    {
        $this->clearSuggestions($model);
    }

    public function deleted(Model $model)
    {
        $this->clearSuggestions($model);
    }

    protected function clearSuggestions(Model $model): void
    {
        // Clear the cache suggestion for the entity type
        if ($model instanceof MiscModel) {
            EntityCache::clearSuggestion($model);
        }
        // @phpstan-ignore-next-line
        foreach ($model->getSuggestions() as $class => $call) {
            $cache = app($class);
            $cache::{$call}();
        }

    }
}
