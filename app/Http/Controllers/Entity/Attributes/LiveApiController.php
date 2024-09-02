<?php

namespace App\Http\Controllers\Entity\Attributes;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttribute;
use App\Http\Requests\UpdateAttribute;
use App\Http\Requests\UpdateEntityAttribute;
use App\Http\Resources\Attributes\LiveAttributeResource;
use App\Models\Attribute;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Attributes\ApiService;
use App\Traits\GuestAuthTrait;

class LiveApiController extends Controller
{
    use GuestAuthTrait;

    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authEntityView($entity);
        $this->authorize('view-attributes', [$entity, $campaign]);

        return LiveAttributeResource::collection($entity->attributes()->with(['entity', 'entity.campaign', 'entity.attributes'])->get());
    }

    public function store(StoreAttribute $request, Campaign $campaign, Entity $entity)
    {
        $this->authEntityView($entity);
        $this->authorize('attributes', [$entity, $campaign]);

        $data = $request->all();
        $data['entity_id'] = $entity->id;
        $attribute = Attribute::create($data);

        return new LiveAttributeResource($attribute);
    }

    public function update(UpdateAttribute $request, Campaign $campaign, Entity $entity, Attribute $attribute)
    {
        $this->authEntityView($entity);
        $this->authorize('attributes', [$entity, $campaign]);

        $attribute->update($request->all());

        return new LiveAttributeResource($attribute);
    }

    public function destroy(Campaign $campaign, Entity $entity, Attribute $attribute)
    {
        $this->authEntityView($entity);
        $this->authorize('attributes', [$entity, $campaign]);

        $attribute->delete();

        return response()->json(null, 204);
    }
}
