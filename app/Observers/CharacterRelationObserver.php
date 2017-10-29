<?php

namespace App\Observers;

use App\Campaign;
use App\Character;
use App\CharacterRelation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class CharacterRelationObserver
{
    /**
     * @param CharacterRelation $character
     */
    public function created(CharacterRelation $characterRelation)
    {
        // Create reverse
        $reverse = CharacterRelation::where([
                'first_id' => $characterRelation->second_id,
                'second_id' => $characterRelation->first_id,
                'relation' => $characterRelation->relation,
            ])
            ->first();
        if (empty($reverse)) {
            $reverse = new CharacterRelation([
                'first_id' => $characterRelation->second_id,
                'second_id' => $characterRelation->first_id,
                'relation' => $characterRelation->relation,
            ]);
            $reverse->save();
        }
    }

    /**
     * @param CharacterRelation $characterRelation
     */
    public function deleted(CharacterRelation $characterRelation)
    {
        // Create reverse
        $reverse = CharacterRelation::where([
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
