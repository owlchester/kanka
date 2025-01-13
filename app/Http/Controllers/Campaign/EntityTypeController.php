<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEntityType;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\EntityTypeService;
use Exception;

class EntityTypeController extends Controller
{
    public function __construct(
        protected EntityTypeService $entityTypeService
    ) {
    }

    public function create(Campaign $campaign)
    {
        $this->authorize('setting', $campaign);

        if (!$campaign->premium()) {
            return view('campaigns.modules.not-premium')
                ->with('campaign', $campaign);
        }


        return view('campaigns.entity-types.create')
            ->with('campaign', $campaign)
        ;
    }

    public function store(StoreEntityType $request, Campaign $campaign)
    {
        $this->authorize('setting', $campaign);

        if (!$campaign->boosted()) {
            return view('campaign.modules')
                ->with('errors', __('This feature is only available on premium campaigns'));
        }
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $this->entityTypeService
            ->campaign($campaign)
            ->save($request->only(['singular', 'plural', 'icon']));

        return redirect()->route('campaign.modules', $campaign)
            ->with('success', __('campaigns/modules.create.success'));
    }

    public function edit(Campaign $campaign, EntityType $entityType)
    {
        $this->authorize('setting', $campaign);
        $this->authorize('update', [$entityType, $campaign]);

        if (!$campaign->premium()) {
            return view('campaigns.modules.not-premium')
                ->with('campaign', $campaign);
        }


        return view('campaigns.entity-types.edit')
            ->with('campaign', $campaign)
            ->with('entityType', $entityType)
        ;
    }

    public function update(StoreEntityType $request, Campaign $campaign, EntityType $entityType)
    {
        $this->authorize('setting', $campaign);
        $this->authorize('update', [$entityType, $campaign]);

        if (!$campaign->boosted()) {
            return view('campaign.modules')
                ->with('errors', __('This feature is only available on premium campaigns'));
        }
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $this->entityTypeService
            ->campaign($campaign)
            ->entityType($entityType)
            ->save($request->only(['singular', 'plural', 'icon']));

        return redirect()->route('campaign.modules', $campaign)
            ->with('success', __('campaigns/modules.rename.success'));
    }

    /**
     * Toggle a module in the campaign's settings
     */
    public function toggle(Campaign $campaign, EntityType $entityType)
    {
        $this->authorize('setting', $campaign);
        $this->authorize('update', [$entityType, $campaign]);

        try {
            $this->entityTypeService
                ->campaign($campaign)
                ->entityType($entityType)
                ->toggle();

            return response()->json([
                'success' => true,
                'status' => $entityType->isEnabled(),
                'toast' => __('campaigns.settings.' . ($entityType->isEnabled() ? 'enabled' : 'disabled'), ['module' => $entityType->plural()])
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false
            ]);
        }
    }
}
