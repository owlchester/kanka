<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreCampaign as Request;
use App\Http\Resources\CampaignResource;
use App\Models\Campaign;
use App\Services\Campaign\CreateService;
use App\Services\Campaign\DeletionService;

class CampaignApiController extends ApiController
{
    public function __construct(protected CreateService $createService, protected DeletionService $deletionService) {}

    public function index(\Illuminate\Http\Request $request)
    {
        $campaigns = $request
            ->user()
            ->campaigns()
            ->with(['members', 'setting', 'roles', 'applications', 'members.user'])
            ->lastSync(request()->get('lastSync'))
            ->paginate();

        return CampaignResource::collection($campaigns);
    }

    public function show(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $resource = new CampaignResource($campaign);

        return $resource->withMentions();
    }

    public function store(Request $request)
    {
        $this->authorize('create', Campaign::class);

        $campaign = $this->createService->user($request->user())
            ->request($request)
            ->create();
        $campaign->refresh();

        return new CampaignResource($campaign);
    }

    public function update(Request $request, Campaign $campaign)
    {
        $this->authorize('update', $campaign);
        $campaign->update($request->all());

        return new CampaignResource($campaign);
    }

    public function destroy(Request $request, Campaign $campaign)
    {
        $this->authorize('delete', $campaign);

        $this->deletionService
            ->campaign($campaign)
            ->user($request->user())
            ->delete();

        return response()->json(null, 204);
    }
}
