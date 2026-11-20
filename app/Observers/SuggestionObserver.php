<?php

namespace App\Observers;

use App\Services\Caches\SuggestionCache;
use Illuminate\Database\Eloquent\Model;

class SuggestionObserver
{
    public function __construct(
        private readonly SuggestionCache $suggestions = new SuggestionCache,
    ) {}

    public function saved(Model $model): void
    {
        $this->suggestions->forgetForModel($model);
    }

    public function deleted(Model $model): void
    {
        $this->suggestions->forgetForModel($model);
    }
}
