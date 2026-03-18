<?php

namespace App\Http\Controllers\Entities;

use App\Http\Controllers\Controller;
use App\Http\Requests\Entities\UpdateListingPreferenceRequest;
use App\Models\Campaign;
use App\Models\EntityListingPreference;
use App\Models\EntityType;
use Illuminate\Http\JsonResponse;

class ListingPreferenceController extends Controller
{
    public function update(
        UpdateListingPreferenceRequest $request,
        Campaign $campaign,
        EntityType $entityType
    ): JsonResponse {
        EntityListingPreference::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'campaign_id' => $campaign->id,
                'type_id' => $entityType->id,
            ],
            array_filter([
                'visible_columns' => $request->input('columns'),
                'layout' => $request->has('layout') ? $request->input('layout') : null,
                'nested' => $request->has('nested') ? $request->boolean('nested') : null,
                'per_page' => $request->has('per_page') ? $request->integer('per_page') : null,
            ], fn ($value) => $value !== null)
        );

        return response()->json(['success' => true]);
    }

    public function destroy(
        Campaign $campaign,
        EntityType $entityType
    ): JsonResponse {
        EntityListingPreference::query()->where([
            'user_id' => auth()->id(),
            'campaign_id' => $campaign->id,
            'type_id' => $entityType->id,
        ])->delete();

        return response()->json(['success' => true]);
    }
}
