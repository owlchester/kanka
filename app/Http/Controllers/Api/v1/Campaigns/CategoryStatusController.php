<?php

namespace App\Http\Controllers\Api\v1\Campaigns;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Resources\Api\CategoryStatusResource;
use App\Models\Campaign;
use App\Models\CategoryStatus;

class CategoryStatusController extends ApiController
{
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        $statuses = CategoryStatus::get();

        return CategoryStatusResource::collection($statuses);
    }
}
