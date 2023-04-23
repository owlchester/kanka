<?php

namespace App\Http\Controllers\Campaign;

use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateModuleName;
use App\Models\EntityType;
use App\Observers\PurifiableTrait;

class ModuleController extends Controller
{
    use PurifiableTrait;

    public function __construct()
    {
        $this->middleware('auth');
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
        $key = 'modules.' . $entityType->id . '.';
        unset($settings[$key . 's']);
        unset($settings[$key . 'p']);
        unset($settings[$key . 'i']);

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
            $settings[$key . 's'] = $singular;
        }
        if (!empty($plural)) {
            $settings[$key . 'p'] = $plural;
        }
        if (!empty($icon)) {
            $settings[$key . 'i'] = $icon;
        }

        $campaign->settings = $settings;
        $campaign->updateQuietly();
        $campaign->touchQuietly();

        return redirect()->route('campaign.modules')
            ->with('success', __('Module renamed'));
    }
}
