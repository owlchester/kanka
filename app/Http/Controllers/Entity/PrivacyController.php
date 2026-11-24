<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Entity\PrivacyService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

/**
 * Class PrivacyController
 */
class PrivacyController extends Controller
{
    protected PrivacyService $service;

    public function __construct(PrivacyService $service)
    {
        $this->service = $service;
    }

    /**
     * @throws AuthorizationException
     */
    public function index(Request $request, Campaign $campaign, Entity $entity)
    {
        return app(PermissionController::class)->view($request, $campaign, $entity);
    }

    /**
     * Toggle an entity's privacy setting
     */
    public function toggle(Campaign $campaign, Entity $entity)
    {
        $this->authorize('privacy', [$entity, $campaign]);

        if ($entity->entityType->isCustom()) {
            $entity->update(['is_private' => ! $entity->is_private]);
        } else {
            $misc = $entity->child;
            $misc->is_private = ! $misc->is_private;
            $misc->update(['is_private' => $misc->is_private]);
            $entity->update(['is_private' => $misc->is_private]);
        }

        return response()->json([
            'toast' => __('entities/permissions.quick.success.' . ($entity->is_private ? 'private' : 'public'), [
                'entity' => $entity->name,
            ]),
            'success' => true,
            'status' => $entity->is_private,
        ]);
    }
}
