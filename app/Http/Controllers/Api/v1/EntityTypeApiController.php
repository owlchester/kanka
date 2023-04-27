<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\EntityType;
use App\Http\Resources\EntityTypeResource as Resource;

class EntitytypeApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        return Resource::collection(EntityType::all());
    }
}
