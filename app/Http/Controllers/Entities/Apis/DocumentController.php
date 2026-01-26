<?php

namespace App\Http\Controllers\Entities\Apis;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;

class DocumentController extends Controller
{
    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authorize('view', $entity);

        return response()->json([
            'document' => $entity->entryForEdition
        ]);
    }
}
