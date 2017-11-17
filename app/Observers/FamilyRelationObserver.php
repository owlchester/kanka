<?php

namespace App\Observers;

use App\Campaign;
use App\Family;
use App\Models\FamilyRelation;
use App\Traits\RelationTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class FamilyRelationObserver
{
    use RelationTrait;

    /**
     * @param FamilyRelation $character
     */
    public function created(FamilyRelation $relation)
    {
        $this->createRelation($relation);
    }
}
