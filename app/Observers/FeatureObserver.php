<?php

namespace App\Observers;

use App\Models\Feature;

class FeatureObserver
{
    use PurifiableTrait;

    public function saving(Feature $feature)
    {
        $feature->name = $this->purify($feature->name);
        $feature->description = $this->purify($feature->description);
    }
}
