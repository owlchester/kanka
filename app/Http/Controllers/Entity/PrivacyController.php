<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Entity\PrivacyService;

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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authorize('privacy', $entity);

        $visibility = $this->service->entity($entity)->visibilities();

        return view('entities.pages.privacy.index')
            ->with('campaign', $campaign)
            ->with('entity', $entity)
            ->with('visibility', $visibility);
    }

    /**
     * Toggle an entity's privacy setting
     */
    public function toggle(Campaign $campaign, Entity $entity)
    {
        $this->authorize('privacy', $entity);

        if ($entity->entityType->isSpecial()) {
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
