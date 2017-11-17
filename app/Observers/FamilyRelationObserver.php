<?php

namespace App\Observers;

use App\Campaign;
use App\Family;
use App\FamilyRelation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class FamilyRelationObserver
{
    /**
     * @param FamilyRelation $character
     */
    public function created(FamilyRelation $characterRelation)
    {
        if (request()->has('two_way')) {
            // Create reverse
            $reverse = FamilyRelation::where([
                'first_id' => $characterRelation->second_id,
                'second_id' => $characterRelation->first_id,
                'relation' => $characterRelation->relation,
            ])
                ->first();
            if (empty($reverse)) {
                $reverse = new FamilyRelation([
                    'first_id' => $characterRelation->second_id,
                    'second_id' => $characterRelation->first_id,
                    'relation' => $characterRelation->relation,
                ]);
                $reverse->save();
            }
        }
    }

    /**
     * @param FamilyRelation $characterRelation
     */
    public function deleted(FamilyRelation $characterRelation)
    {
        // Create reverse
//        $reverse = FamilyRelation::where([
//            'second_id' => $characterRelation->first_id,
//            'first_id' => $characterRelation->second_id,
//            'relation' => $characterRelation->relation,
//            ])
//            ->first();
//        if (!empty($reverse)) {
//            $reverse->delete();
//        }
    }
}
