<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Models\Entity;

/**
 * Class PrivacyController
 * @package App\Http\Controllers\Entity
 */
class PrivacyController extends Controller
{
    /**
     * @param Entity $entity
     */
    public function toggle(Entity $entity)
    {
        $this->authorize('privacy', $entity);

        $misc = $entity->child;
        $misc->is_private = !$misc->is_private;
        $misc->update(['is_private']);

        return response()->json([
            'success' => true,
            'status' => $entity->is_private
        ]);
    }
}
