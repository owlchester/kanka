<?php

namespace App\Observers;

use App\Campaign;
use App\Models\Character;
use App\Models\CharacterRelation;
use App\Traits\RelationTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class CharacterRelationObserver
{
    use RelationTrait;

    /**
     * @param CharacterRelation $character
     */
    public function created(CharacterRelation $relation)
    {
        $this->createRelation($relation);
    }
}
