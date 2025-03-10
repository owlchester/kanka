<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteEntityType;
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
            return view('campaigns.entity-types.not-premium')
                ->with('campaign', $campaign);
        }
        if ($campaign->entityTypes->count() >= config('limits.campaigns.modules')) {
            return view('campaigns.entity-types.max-reached')
                ->with('campaign', $campaign);
        }


        return view('campaigns.entity-types.create')
            ->with('campaign', $campaign)
        ;
    }

    public function store(StoreEntityType $request, Campaign $campaign)
    {
        $this->authorize('setting', $campaign);

        if (!$campaign->premium()) {
            return view('campaign.modules')
                ->with('errors', __('This feature is only available on premium campaigns'));
        } elseif ($campaign->entityTypes->count() > config('limits.campaigns.modules')) {
            return view('campaigns.entity-types.max-reached')
                ->with('campaign', $campaign);
        }
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $this->entityTypeService
            ->campaign($campaign)
            ->request($request)
            ->save();

        return redirect()->route('campaign.modules', $campaign)
            ->with('success', __('campaigns/modules.create.success'));
    }

    public function edit(Campaign $campaign, EntityType $entityType)
    {
        $this->authorize('setting', $campaign);
        $this->authorize('update', [$entityType, $campaign]);

        if (!$campaign->premium()) {
            return view('campaigns.entity-types.not-premium')
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

        if (!$campaign->premium()) {
            return view('campaign.modules')
                ->with('errors', __('This feature is only available on premium campaigns'));
        }
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $this->entityTypeService
            ->campaign($campaign)
            ->entityType($entityType)
            ->request($request)
            ->save();

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
    public function confirm(Campaign $campaign, EntityType $entityType)
    {
        $this->authorize('setting', $campaign);
        $this->authorize('delete', [$entityType, $campaign]);



        return view('campaigns.entity-types.confirm')
            ->with('campaign', $campaign)
            ->with('entityType', $entityType)
        ;
    }

    public function destroy(DeleteEntityType $request, Campaign $campaign, EntityType $entityType)
    {
        $this->authorize('setting', $campaign);
        $this->authorize('delete', [$entityType, $campaign]);

        if (request()->ajax()) {
            return response()->json();
        }

        $this->entityTypeService
            ->campaign($campaign)
            ->entityType($entityType)
            ->delete();


        return redirect()->route('campaign.modules', $campaign)
            ->with('success', __('campaigns/modules.delete.success', ['name' => $entityType->name()]));
    }
}
