<?php

namespace App\Observers;

use App\Campaign;
use App\Models\Organisation;
use App\Models\OrganisationRelation;
use App\Traits\RelationTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class OrganisationRelationObserver
{
    use RelationTrait;

    /**
     * @param OrganisationRelation $character
     */
    public function created(OrganisationRelation $relation)
    {
        $this->createRelation($relation);
    }
}
