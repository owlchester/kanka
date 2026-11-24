<?php

namespace App\Http\Controllers\Entity\Maps;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMapMarker;
use App\Http\Resources\Maps\Explore\PinPreviewResource;
use App\Http\Resources\Maps\Explore\PinResource;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\MapMarker;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class MarkerController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function preview(Campaign $campaign, Entity $entity, MapMarker $mapMarker)
    {
        $this->campaign($campaign)->authEntityView($entity);
        $this->guardMarker($entity, $mapMarker);

        return response()->json(new PinPreviewResource($mapMarker)->campaign($campaign));
    }

    public function store(StoreMapMarker $request, Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authEntityView($entity);
        if (! $entity->isMap()) {
            abort(404);
        }
        $this->authorize('update', $entity);

        $marker = MapMarker::create($request->validated() + ['map_id' => $entity->child->id]);

        return response()->json(new PinResource($marker)->campaign($campaign)->mapEntity($entity), 201);
    }

    public function update(StoreMapMarker $request, Campaign $campaign, Entity $entity, MapMarker $mapMarker)
    {
        $this->campaign($campaign)->authEntityView($entity);
        $this->guardMarker($entity, $mapMarker);
        $this->authorize('update', $entity);

        $mapMarker->update($request->validated());

        return response()->json(new PinResource($mapMarker)->campaign($campaign)->mapEntity($entity));
    }

    public function destroy(Campaign $campaign, Entity $entity, MapMarker $mapMarker)
    {
        $this->campaign($campaign)->authEntityView($entity);
        $this->guardMarker($entity, $mapMarker);
        $this->authorize('update', $entity);

        $mapMarker->delete();

        return response()->json(null, 204);
    }

    protected function guardMarker(Entity $entity, MapMarker $mapMarker): void
    {
        if (! $entity->isMap() || $mapMarker->map_id !== $entity->child->id) {
            abort(404);
        }
    }
}
