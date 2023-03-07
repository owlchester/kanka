<?php

namespace App\Http\Controllers\Entity;

use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Entity\PreviewService;
use App\Services\SearchService;
use App\Traits\GuestAuthTrait;
use Illuminate\Support\Facades\Auth;

class PreviewController extends Controller
{
    /**
     * Guest Auth Trait
     */
    use GuestAuthTrait;

    protected PreviewService $service;

    /**
     * AbilityController constructor.
     * @param PreviewService $service
     */
    public function __construct(PreviewService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Entity $entity)
    {
        // Policies will always fail if they can't resolve the user.
        if (auth()->check()) {
            $this->authorize('view', $entity->child);
        } else {
            $this->authorizeEntityForGuest(\App\Models\CampaignPermission::ACTION_READ, $entity->child);
        }

        if (auth()->check()) {
            $service = app()->make(SearchService::class);
            $service->campaign($campaign)
                ->user(auth()->user())
                ->logView($entity);
        }

        return response()->json(
            $this
                ->service
                ->entity($entity)
                ->campaign($campaign)
                ->preview()
        );
    }
}
