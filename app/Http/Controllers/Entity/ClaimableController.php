<?php

namespace App\Http\Controllers\Entity;

use App\Enums\CampaignFlags;
use App\Facades\CampaignCache;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;

class ClaimableController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update(Campaign $campaign, Entity $entity)
    {
        $this->authorize('admin', $campaign);

        abort_unless(
            $entity->isCharacter() && CampaignCache::campaign($campaign)->flags()->has(CampaignFlags::PlayerHub->value),
            404
        );

        $entity->update(['is_claimable' => ! $entity->is_claimable]);

        return redirect()->back()
            ->with(
                'success',
                __('entities/actions.claimable.success.' . ($entity->is_claimable ? 'set' : 'unset'), [
                    'name' => $entity->name,
                ])
            );
    }
}
