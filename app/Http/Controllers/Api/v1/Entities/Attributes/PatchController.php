<?php

namespace App\Http\Controllers\Api\v1\Entities\Attributes;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Requests\SaveAttributes;
use App\Http\Resources\AttributeResource as Resource;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Api\BulkAttributeService;

class PatchController extends ApiController
{
    public function __construct(
        protected BulkAttributeService $service,
    ) {}

    public function patch(SaveAttributes $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);

        $attributes = $request->get('attribute', []);
        $this->service
            ->entity($entity)
            ->save($attributes, false)
            ->touch();

        return Resource::collection($entity->attributes()->with('entity')->get());
    }
}
