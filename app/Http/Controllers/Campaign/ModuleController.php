<?php

namespace App\Http\Controllers\Campaign;

use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateModuleName;
use App\Models\EntityType;
use App\Observers\PurifiableTrait;
use App\Services\SidebarService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ModuleController extends Controller
{
    use PurifiableTrait;

    protected SidebarService $sidebarService;

    public function __construct(SidebarService $sidebarService)
    {
        $this->middleware('auth');
        $this->sidebarService = $sidebarService;
    }

    public function edit(EntityType $entityType)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('setting', $campaign);

        if (!$campaign->superboosted()) {
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

        if (!$campaign->superboosted()) {
            return view('campaign.modules')
                ->with('errors', __('This feature is only available on premium campaigns'));
        }

        $settings = $campaign->settings;

        $key = $entityType->id;
        unset($settings['modules'][$key]['s']);
        unset($settings['modules'][$key]['p']);
        unset($settings['modules'][$key]['i']);

        $singular = $plural = $icon = null;
        if ($request->filled('singular')) {
            $singular = $this->purify(trim($request->get('singular')));
        }
        if ($request->filled('plural')) {
            $plural = $this->purify(trim($request->get('plural')));
        }
        if ($request->filled('icon')) {
            $icon = $this->purify(trim($request->get('icon')));
        }

        if (!empty($singular)) {
            $settings['modules'][$key]['s'] = $singular;
        }
        if (!empty($plural)) {
            $settings['modules'][$key]['p'] = $plural;
        }
        if (!empty($icon)) {
            $settings['modules'][$key]['i'] = $icon;
        }

        $campaign->settings = $settings;
        $campaign->updateQuietly();
        $campaign->touchQuietly();

        return redirect()->route('campaign.modules')
            ->with('success', __('Module renamed'));
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
