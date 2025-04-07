<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\EntityTypeResource as Resource;
use App\Models\EntityType;

class EntityTypeApiController extends ApiController
{
    public function index()
    {
        return Resource::collection(EntityType::default()->paginate());
    }
}
