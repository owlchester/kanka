<?php

namespace App\Http\Controllers\Campaign;

use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateModuleName;
use App\Models\EntityType;
use App\Services\Campaign\ModuleService;
use App\Services\SidebarService;
use Illuminate\Support\Str;

class ModuleController extends Controller
{
    protected SidebarService $sidebarService;
    protected ModuleService $moduleService;

    public function __construct(SidebarService $sidebarService, ModuleService $moduleService)
    {
        $this->middleware('auth');
        $this->sidebarService = $sidebarService;
        $this->moduleService = $moduleService;
    }

    public function edit(EntityType $entityType)
    {
        $campaign = CampaignLocalization::getCampaign();
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

    public function update(UpdateModuleName $request, EntityType $entityType)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('setting', $campaign);

        if (!$campaign->boosted()) {
            return view('campaign.modules')
                ->with('errors', __('This feature is only available on premium and boosted campaigns'));
        }

        $this->moduleService
            ->campaign($campaign)
            ->update($request, $entityType);

        return redirect()->route('campaign.modules')
            ->with('success', __('campaigns/modules.rename.success'));
    }

    public function reset()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('setting', $campaign);

        $settings = $campaign->settings;
        unset($settings['modules']);
        foreach ($settings as $name => $val) {
            if (Str::startsWith($name, 'modules.')) {
                unset($settings[$name]);
            }
        }
        $campaign->settings = $settings;
        $campaign->save();


        $this->sidebarService
            ->campaign($campaign)
            ->clearCache();

        return redirect()
            ->route('campaign.modules')
            ->with('success', __('campaigns/modules.reset.success'));
    }
}
