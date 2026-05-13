<?php

namespace App\Http\Controllers\Onboarding;

use App\Http\Controllers\Controller;
use App\Http\Requests\Onboarding\QuickCreateRequest;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\Location;
use App\Models\Organisation;
use Illuminate\Http\JsonResponse;

class QuickCreateController extends Controller
{
    public function store(QuickCreateRequest $request, Campaign $campaign): JsonResponse
    {
        $this->authorize('update', $campaign);

        $name = $request->validated('name');
        $type = $request->validated('type');

        [$model, $routeName] = match ($type) {
            'character' => [
                Character::create(['name' => $name, 'campaign_id' => $campaign->id]),
                'characters.show',
            ],
            'location' => [
                Location::create(['name' => $name, 'campaign_id' => $campaign->id]),
                'locations.show',
            ],
            'organisation' => [
                Organisation::create(['name' => $name, 'campaign_id' => $campaign->id]),
                'organisations.show',
            ],
        };

        $model->entity->update(['source' => 'onboarding_widget']);

        return response()->json([
            'id' => $model->id,
            'name' => $model->name,
            'url' => route($routeName, [$campaign, $model]),
        ]);
    }
}
