<?php

namespace App\Observers;

use App\Enums\FeatureStatus;
use App\Events\FeatureCreated;
use App\Jobs\Discord\UpdateFeatureUpvotes;
use App\Models\Feature;

class FeatureObserver
{
    public function created(Feature $feature)
    {
        FeatureCreated::dispatch($feature);
    }

    public function updated(Feature $feature): void
    {
        if ($feature->wasChanged('status_id') && $feature->status_id === FeatureStatus::Done && $feature->message_id) {
            UpdateFeatureUpvotes::dispatch($feature->id)->afterCommit();
        }
    }
}
