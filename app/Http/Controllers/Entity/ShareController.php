<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShare;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Campaign\ShareService as CampaignShareService;
use App\Services\Entity\ShareService;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;
use Illuminate\Http\JsonResponse;

class ShareController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function __construct(
        protected ShareService $shareService,
        protected CampaignShareService $campaignShareService,
    ) {}

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function setup(Campaign $campaign, Entity $entity): \Illuminate\Contracts\View\View
    {
        $this->authorize('update', $entity);

        return view('entities.pages.share.setup', compact(
            'campaign',
            'entity',
        ));
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function save(StoreShare $request, Campaign $campaign, Entity $entity): JsonResponse
    {
        $this->authorize('update', $entity);

        $visibilityMode = $request->input('visibility_mode');
        $campaignVisibility = $request->input('campaign_visibility');

        if ($campaignVisibility === 'public') {
            $this->authorize('update', $campaign);
        }

        if ($visibilityMode) {
            $this->shareService
                ->campaign($campaign)
                ->entity($entity);

            if ($visibilityMode === 'entity') {
                $this->shareService->shareEntity();
            } elseif ($visibilityMode === 'global') {
                $this->shareService->shareGlobal();
            }

            $entity->refresh();
        } elseif ($campaignVisibility === 'public') {
            $this->campaignShareService
                ->campaign($campaign)
                ->makePublic();
        }

        return response()->json([
            'success' => true,
            'campaign_public' => $campaign->isPublic(),
            'entity_private' => (bool) $entity->is_private,
        ]);
    }
}
