<?php

namespace App\Http\Controllers\Onboarding;

use App\Http\Controllers\Controller;
use App\Http\Requests\Onboarding\QuickCreateRequest;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\Entity\StandardEntityCreationService;
use Illuminate\Http\JsonResponse;

class QuickCreateController extends Controller
{
    public function store(QuickCreateRequest $request, Campaign $campaign): JsonResponse
    {
        $this->authorize('update', $campaign);

        $name = $request->validated('name');
        $type = (string) $request->validated('type');
        $entityType = EntityType::where('code', $type)->firstOrFail();
        $creator = app(StandardEntityCreationService::class);

        [$model, $routeName] = match ($type) {
            'character' => [
                $creator->campaign($campaign)->entityType($entityType)->create(['name' => $name]),
                'characters.show',
            ],
            'location' => [
                $creator->campaign($campaign)->entityType($entityType)->create(['name' => $name]),
                'locations.show',
            ],
            'organisation' => [
                $creator->campaign($campaign)->entityType($entityType)->create(['name' => $name]),
                'organisations.show',
            ],
            default => throw new \InvalidArgumentException("Unexpected type: {$type}"),
        };

        $model->entity->update(['source' => 'onboarding_widget']);

        return response()->json([
            'id' => $model->id,
            'name' => $model->name,
            'url' => route($routeName, [$campaign, $model]),
        ]);
    }
}
