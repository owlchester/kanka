<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Models\CampaignRole;
use App\Models\Entity;
use App\Services\Entity\PrivacyService;

/**
 * Class PrivacyController
 * @package App\Http\Controllers\Entity
 */
class PrivacyController extends Controller
{
    /** @var PrivacyService */
    protected $service;

    public function __construct(PrivacyService $service)
    {
        $this->service = $service;
    }

    public function index(Entity $entity)
    {
        $this->authorize('privacy', $entity);

        $visibility = $this->service->entity($entity)->visibilities();

        return view('entities.pages.privacy.index')
            ->with('entity', $entity)
            ->with('visibility', $visibility)
            ->with('model', $entity->child)
        ;
    }
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
            'toast' => __('entities/permissions.quick.success.' . ($misc->is_private ? 'private' : 'public'), [
                'entity' => $misc->name
            ]),
            'success' => true,
            'status' => $entity->is_private
        ]);
    }
}
