<?php

namespace App\Http\Controllers\Api\v1\Campaigns;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Requests\DeleteCategoryStatus;
use App\Http\Requests\ReorderCategoryStatuses;
use App\Http\Requests\StoreCategoryStatus;
use App\Http\Resources\Api\CategoryStatusResource;
use App\Models\Campaign;
use App\Models\CategoryStatus;
use App\Models\EntityType;
use App\Services\CategoryStatusService;

class CategoryStatusController extends ApiController
{
    public function __construct(private CategoryStatusService $statuses) {}

    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        $statuses = CategoryStatus::inCampaign($campaign)->with('entityType')->orderBy('category_id')->orderBy('sort_order')->orderBy('id')->get();

        return CategoryStatusResource::collection($statuses);
    }

    public function category(Campaign $campaign, EntityType $entityType)
    {
        $this->authorize('access', $campaign);
        abort_unless($entityType->isCustom() && $entityType->campaign_id === $campaign->id, 404);

        return CategoryStatusResource::collection($entityType->statuses()->where('campaign_id', $campaign->id)->get());
    }

    public function store(StoreCategoryStatus $request, Campaign $campaign, EntityType $entityType)
    {
        $saved = $this->statuses->sync($campaign, $entityType, [$request->validated()], false);

        return (new CategoryStatusResource($saved[0]))->response()->setStatusCode(201);
    }

    public function update(StoreCategoryStatus $request, Campaign $campaign, EntityType $entityType, CategoryStatus $status)
    {
        abort_unless($status->campaign_id === $campaign->id && $status->category_id === $entityType->id, 404);
        $this->statuses->sync($campaign, $entityType, [array_replace($status->only(['label', 'icon', 'is_default']), $request->validated(), ['id' => $status->id])], false);

        return new CategoryStatusResource($status->refresh());
    }

    public function reorder(ReorderCategoryStatuses $request, Campaign $campaign, EntityType $entityType)
    {
        $this->statuses->reorder($campaign, $entityType, $request->validated('ids'));

        return $this->category($campaign, $entityType);
    }

    public function destroy(DeleteCategoryStatus $request, Campaign $campaign, EntityType $entityType, CategoryStatus $status)
    {
        $this->statuses->delete($campaign, $entityType, $status, $request->validated());

        return response()->noContent();
    }
}
