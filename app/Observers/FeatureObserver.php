<?php

namespace App\Observers;

use App\Events\FeatureCreated;
use App\Models\Feature;

class FeatureObserver
{
    public function created(Feature $feature)
    {
        FeatureCreated::dispatch($feature);
    }
}
