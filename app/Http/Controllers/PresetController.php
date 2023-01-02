<?php

namespace App\Http\Controllers;

use App\Facades\CampaignLocalization;
use App\Http\Requests\StorePreset;
use App\Models\Preset;
use App\Models\PresetType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PresetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('campaign.member');
    }

    public function index(PresetType $presetType)
    {
        $presets = Preset::inType($presetType->id)->orderBy('name')->get();

        return view('presets.list')
            ->with('presets', $presets)
            ->with('presetType', $presetType)
            ->with('from', request()->get('from'))
        ;
    }

    public function show(PresetType $presetType, Preset $preset)
    {
        return response()
            ->json(['preset' => $preset->config]);
    }

    public function create(PresetType $presetType)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('mapPresets', $campaign);

        $from = request()->get('from', 'dashboard');
        return view('presets.forms.create')
            ->with('presetType', $presetType)
            ->with('from', $from);
    }

    public function store(StorePreset $request, PresetType $presetType)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('mapPresets', $campaign);

        $data = $request->only('name', 'config', 'visibility_id');
        $data['type_id'] = $presetType->id;
        $preset = new Preset();
        $preset = $preset->create($data);

        list($route, $params) = $this->parseFrom($request);

        return redirect()
            ->route($route, $params)
            ->with('success', __('presets.create.success', ['name' => $preset->name]));
    }

    public function edit(PresetType $presetType, Preset $preset)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('mapPresets', $campaign);

        $from = request()->get('from', 'dashboard');
        return view('presets.forms.edit')
            ->with('presetType', $presetType)
            ->with('preset', $preset)
            ->with('from', $from)
        ;
    }

    public function update(StorePreset $request, PresetType $presetType, Preset $preset)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('mapPresets', $campaign);

        $data = $request->only('name', 'config', 'visibility_id');
        $preset->update($data);

        list($route, $params) = $this->parseFrom($request);

        return redirect()
            ->route($route, $params)
            ->with('success', __('presets.edit.success', ['name' => $preset->name]));
    }

    public function destroy(Request $request, PresetType $presetType, Preset $preset)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('mapPresets', $campaign);

        $preset->delete();

        list($route, $params) = $this->parseFrom($request);

        return redirect()
            ->route($route, $params)
            ->with('success', __('presets.destroy.success', ['name' => $preset->name]));
    }

    protected function parseFrom(Request $request)
    {
        $from = $request->get('from');
        if (empty($from) || $from === 'dashboard') {
            return ['dashboard', null];
        }
        $from = base64_decode($from);
        $from = explode(':', $from);

        return [$from[0], $from[1]];
    }
}
