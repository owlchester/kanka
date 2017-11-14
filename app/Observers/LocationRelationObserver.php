<?php

namespace App\Observers;

use App\Campaign;
use App\Location;
use App\Models\LocationRelation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class LocationRelationObserver
{
    /**
     * @param LocationRelation $character
     */
    public function created(LocationRelation $characterRelation)
    {
        // Create reverse
        $reverse = LocationRelation::where([
                'first_id' => $characterRelation->second_id,
                'second_id' => $characterRelation->first_id,
                'relation' => $characterRelation->relation,
            ])
            ->first();
        if (empty($reverse)) {
            $reverse = new LocationRelation([
                'first_id' => $characterRelation->second_id,
                'second_id' => $characterRelation->first_id,
                'relation' => $characterRelation->relation,
            ]);
            $reverse->save();
        }
    }

    /**
     * @param LocationRelation $characterRelation
     */
    public function deleted(LocationRelation $characterRelation)
    {
        // Create reverse
        $reverse = LocationRelation::where([
            'second_id' => $characterRelation->first_id,
            'first_id' => $characterRelation->second_id,
            'relation' => $characterRelation->relation,
            ])
            ->first();
        if (!empty($reverse)) {
            $reverse->delete();
        }
    }
}
