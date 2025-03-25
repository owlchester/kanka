<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePreset;
use App\Models\Campaign;
use App\Models\Preset;
use App\Models\PresetType;
use Illuminate\Http\Request;

class PresetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Campaign $campaign, PresetType $presetType)
    {
        $presets = Preset::inType($presetType->id)->orderBy('name')->get();

        return view('presets.list')
            ->with('campaign', $campaign)
            ->with('presets', $presets)
            ->with('presetType', $presetType)
            ->with('from', request()->get('from'));
    }

    public function show(Campaign $campaign, PresetType $presetType, Preset $preset)
    {
        return response()
            ->json(['preset' => $preset->config]);
    }

    public function create(Campaign $campaign, PresetType $presetType)
    {
        $this->authorize('mapPresets', $campaign);

        $from = request()->get('from', 'dashboard');

        return view('presets.forms.create')
            ->with('campaign', $campaign)
            ->with('presetType', $presetType)
            ->with('from', $from);
    }

    public function store(StorePreset $request, Campaign $campaign, PresetType $presetType)
    {
        $this->authorize('mapPresets', $campaign);

        $data = $request->only('name', 'config', 'visibility_id');
        $data['type_id'] = $presetType->id;
        $data['campaign_id'] = $campaign->id;
        $preset = new Preset;
        $preset = $preset->create($data);

        [$route, $params] = $this->parseFrom($request);
        if (! is_array($params)) {
            $params = [$params];
        }
        $params['campaign'] = $campaign;

        return redirect()
            ->route($route, $params)
            ->with('success', __('presets.create.success', ['name' => $preset->name]));
    }

    public function edit(Campaign $campaign, PresetType $presetType, Preset $preset)
    {
        $this->authorize('mapPresets', $campaign);

        $from = request()->get('from', 'dashboard');

        return view('presets.forms.edit')
            ->with('campaign', $campaign)
            ->with('presetType', $presetType)
            ->with('preset', $preset)
            ->with('from', $from);
    }

    public function update(StorePreset $request, Campaign $campaign, PresetType $presetType, Preset $preset)
    {
        $this->authorize('mapPresets', $campaign);

        $data = $request->only('name', 'config', 'visibility_id');
        $preset->update($data);

        [$route, $params] = $this->parseFrom($request);
        if (! is_array($params)) {
            $params = [$params];
        }
        $params['campaign'] = $campaign;

        return redirect()
            ->route($route, $params)
            ->with('success', __('presets.edit.success', ['name' => $preset->name]));
    }

    public function destroy(Request $request, Campaign $campaign, PresetType $presetType, Preset $preset)
    {
        $this->authorize('mapPresets', $campaign);
        $preset->delete();

        [$route, $params] = $this->parseFrom($request);
        if (! is_array($params)) {
            $params = [$params];
        }
        $params['campaign'] = $campaign;

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

        if (count($from) !== 2) {
            return ['dashboard', null];
        }

        return [$from[0], $from[1]];
    }
}
