<?php

namespace App\Http\Controllers\Entity\Maps;

use App\Enums\MapMarkerShape;
use App\Enums\Visibility;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMapPreset;
use App\Http\Resources\Maps\Explore\PresetResource;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Preset;
use App\Models\PresetType;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class PresetController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function store(StoreMapPreset $request, Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authEntityView($entity);
        if (! $entity->isMap()) {
            abort(404);
        }
        $this->authorize('mapPresets', $campaign);

        $preset = Preset::create([
            'name' => $request->validated('name'),
            'type_id' => PresetType::MARKER,
            'campaign_id' => $campaign->id,
            'visibility_id' => Visibility::All,
            'config' => $this->configFromRequest($request),
        ]);

        return response()->json(new PresetResource($preset)->campaign($campaign)->mapEntity($entity), 201);
    }

    public function update(StoreMapPreset $request, Campaign $campaign, Entity $entity, Preset $preset)
    {
        $this->campaign($campaign)->authEntityView($entity);
        if (! $entity->isMap()) {
            abort(404);
        }
        $this->authorize('mapPresets', $campaign);

        $preset->update([
            'name' => $request->validated('name'),
            'config' => $this->configFromRequest($request),
        ]);

        return response()->json(new PresetResource($preset)->campaign($campaign)->mapEntity($entity));
    }

    public function destroy(Campaign $campaign, Entity $entity, Preset $preset)
    {
        $this->campaign($campaign)->authEntityView($entity);
        if (! $entity->isMap()) {
            abort(404);
        }
        $this->authorize('mapPresets', $campaign);

        $preset->delete();

        return response()->json(null, 204);
    }

    /**
     * @return array<string, mixed>
     */
    protected function configFromRequest(StoreMapPreset $request): array
    {
        $shapeId = match ($request->validated('shape')) {
            'label' => MapMarkerShape::label->value,
            'circle' => MapMarkerShape::circle->value,
            'poly' => MapMarkerShape::poly->value,
            'path' => MapMarkerShape::path->value,
            default => MapMarkerShape::marker->value,
        };

        return array_filter([
            'shape_id' => $shapeId,
            'colour' => $request->validated('colour'),
            'icon' => $request->validated('icon'),
            'custom_icon' => $request->validated('custom_icon'),
            'opacity' => $request->validated('opacity'),
            'is_draggable' => $request->boolean('is_draggable'),
            'css' => $request->validated('css'),
        ], fn ($value) => $value !== null);
    }
}
