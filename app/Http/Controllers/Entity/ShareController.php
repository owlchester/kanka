<?php

namespace App\Http\Controllers\Entity;

use App\Enums\CampaignVisibility;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShare;
use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\Entity;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;
use Illuminate\Http\JsonResponse;

class ShareController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

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

        if ($visibilityMode) {
            $publicRole = $campaign->roles()->public()->first();

            if ($visibilityMode === 'entity') {
                if ($entity->is_private) {
                    $entity->update(['is_private' => false]);
                }

                CampaignPermission::updateOrCreate(
                    [
                        'campaign_id'      => $campaign->id,
                        'campaign_role_id' => $publicRole->id,
                        'entity_id'        => $entity->id,
                        'action'           => CampaignPermission::ACTION_READ,
                    ],
                    [
                        'entity_type_id' => $entity->type_id,
                        'access'         => true,
                    ]
                );
            } elseif ($visibilityMode === 'global') {
                foreach (array_values(config('entities.ids')) as $typeId) {
                    CampaignPermission::updateOrCreate(
                        [
                            'campaign_id'      => $campaign->id,
                            'campaign_role_id' => $publicRole->id,
                            'entity_type_id'   => $typeId,
                            'entity_id'        => null,
                            'action'           => CampaignPermission::ACTION_READ,
                        ],
                        [
                            'access' => true,
                        ]
                    );
                }

                // Also make this entity visible if it was private
                if ($entity->is_private) {
                    $entity->update(['is_private' => false]);
                }
            }

            $entity->refresh();
        } elseif ($campaignVisibility === 'public') {
            $campaign->update(['visibility_id' => CampaignVisibility::public->value]);
        }

        return response()->json([
            'success'         => true,
            'campaign_public' => $campaign->isPublic(),
            'entity_private'  => (bool) $entity->is_private,
        ]);
    }
}
