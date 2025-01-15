<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateModuleName;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\Campaign\ModuleEditService;
use App\Services\EntityTypeService;
use App\Services\SidebarService;
use Exception;

class ModuleController extends Controller
{
    public function __construct(
        protected SidebarService $sidebarService,
        protected ModuleEditService $moduleEditService,
        protected EntityTypeService $entityTypeService
    ) {
    }

    public function index(Campaign $campaign)
    {
        $this->authorize('setting', $campaign);

        $entityTypes = $this->entityTypeService
            ->campaign($campaign)
            ->exclude(config('entities.ids.attribute_template'))
            ->withDisabled()
            ->ordered();

        return view('campaigns.modules.index')
            ->with('campaign', $campaign)
            ->with('entityTypes', $entityTypes)
            ->with('canReset', true);
    }

    public function edit(Campaign $campaign, EntityType $entityType)
    {
        $this->authorize('setting', $campaign);

        if (!$campaign->boosted()) {
            return view('campaigns.modules.not-premium')
                ->with('campaign', $campaign);
        }

        $singular = $campaign->moduleName($entityType->id);
        $plural = $campaign->moduleName($entityType->id, true);
        $icon = $campaign->moduleIcon($entityType->id);

        return view('campaigns.modules.edit')
            ->with('campaign', $campaign)
            ->with('entityType', $entityType)
            ->with('singular', $singular)
            ->with('plural', $plural)
            ->with('icon', $icon)
        ;
    }

    public function update(UpdateModuleName $request, Campaign $campaign, EntityType $entityType)
    {
        $this->authorize('setting', $campaign);

        if (!$campaign->boosted()) {
            return view('campaign.modules')
                ->with('errors', __('This feature is only available on premium and boosted campaigns'));
        }
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $this->moduleEditService
            ->campaign($campaign)
            ->update($request, $entityType);

        return redirect()->route('campaign.modules', $campaign)
            ->with('success', __('campaigns/modules.rename.success'));
    }

    public function reset(Campaign $campaign)
    {
        $this->authorize('setting', $campaign);

        $this->moduleEditService
            ->campaign($campaign)
            ->reset();

        $this->sidebarService
            ->campaign($campaign)
            ->clearCache();

        return redirect()
            ->route('campaign.modules', $campaign)
            ->with('success', __('campaigns/modules.reset.success'));
    }


    /**
     * Toggle a module in the campaign's settings
     */
    public function toggle(Campaign $campaign, string $module)
    {
        $this->authorize('setting', $campaign);

        try {
            $status = $this->moduleEditService
                ->campaign($campaign)
                ->toggle($module);

            return response()->json([
                'success' => true,
                'status' => $campaign->setting->{$module},
                'toast' => __('campaigns.settings.' . ($status ? 'enabled' : 'disabled'), ['module' => __('entities.' . $module)])
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false
            ]);
        }
    }
}
