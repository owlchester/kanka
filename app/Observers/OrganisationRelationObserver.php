<?php

namespace App\Observers;

use App\Campaign;
use App\Organisation;
use App\Models\OrganisationRelation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class OrganisationRelationObserver
{
    /**
     * @param OrganisationRelation $character
     */
    public function created(OrganisationRelation $characterRelation)
    {
        // Create reverse
        $reverse = OrganisationRelation::where([
                'first_id' => $characterRelation->second_id,
                'second_id' => $characterRelation->first_id,
                'relation' => $characterRelation->relation,
            ])
            ->first();
        if (empty($reverse)) {
            $reverse = new OrganisationRelation([
                'first_id' => $characterRelation->second_id,
                'second_id' => $characterRelation->first_id,
                'relation' => $characterRelation->relation,
            ]);
            $reverse->save();
        }
    }

    /**
     * @param OrganisationRelation $characterRelation
     */
    public function deleted(OrganisationRelation $characterRelation)
    {
        // Create reverse
        $reverse = OrganisationRelation::where([
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
