<?php

namespace App\Observers;

use App\Facades\EntityLogger;
use App\Models\Character;
use App\Models\FamilyTree;

class FamilyTreeObserver
{
    public function saved(FamilyTree $familyTree)
    {
        EntityLogger::entity($familyTree->family->entity)->updatedFamilyTree();
    }
}
