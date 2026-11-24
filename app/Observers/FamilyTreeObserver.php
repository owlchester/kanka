<?php

namespace App\Observers;

use App\Facades\EntityLogger;
use App\Models\FamilyTree;

class FamilyTreeObserver
{
    public function saved(FamilyTree $familyTree)
    {
        if ($familyTree->family?->entity && auth()->check()) {
            EntityLogger::entity($familyTree->family->entity)->updatedFamilyTree();
        }
    }
}
