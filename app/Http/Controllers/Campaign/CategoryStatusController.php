<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteCategoryStatus;
use App\Models\Campaign;
use App\Models\CategoryStatus;
use App\Models\Entity;
use App\Models\EntityType;
use App\Services\CategoryStatusService;

class CategoryStatusController extends Controller
{
    public function __construct(private CategoryStatusService $statuses) {}

    public function confirm(Campaign $campaign, EntityType $entityType, CategoryStatus $status)
    {
        $this->authorize('setting', $campaign);
        $this->statuses->authorizeCategory($campaign, $entityType);
        abort_unless($status->campaign_id === $campaign->id && $status->category_id === $entityType->id, 404);

        return view('campaigns.entity-types.statuses.delete', [
            'campaign' => $campaign,
            'entityType' => $entityType,
            'status' => $status,
            'count' => Entity::withTrashed()->where('campaign_id', $campaign->id)->where('status_id', $status->id)->count(),
            'statuses' => $entityType->statuses()->where('id', '!=', $status->id)->get(),
        ]);
    }

    public function destroy(DeleteCategoryStatus $request, Campaign $campaign, EntityType $entityType, CategoryStatus $status)
    {
        $this->statuses->delete($campaign, $entityType, $status, $request->validated());

        return redirect()->route('entity_types.edit', [$campaign, $entityType, 'section' => 'statuses'])->with('success', __('Status deleted.'));
    }
}
