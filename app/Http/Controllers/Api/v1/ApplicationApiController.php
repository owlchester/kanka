<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Campaigns\ApproveApplication;
use App\Http\Requests\Campaigns\RejectApplication;
use App\Http\Resources\ApplicationResource as Resource;
use App\Models\Application;
use App\Models\Campaign;
use App\Services\Campaign\ApplicationService;

class ApplicationApiController extends ApiController
{
    public function __construct(protected ApplicationService $service)
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('applications', $campaign);

        return Resource::collection($campaign
            ->applications()
            ->paginate());
    }

    /**
     * @return resource
     */
    public function show(Campaign $campaign, Application $application)
    {
        $this->authorize('applications', $campaign);

        return new Resource($application);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function reject(RejectApplication $request, Campaign $campaign, Application $application)
    {
        $this->authorize('applications', $campaign);

        $request->merge(['action' => 'reject']);

        $note = $this->service
            ->user(auth()->user())
            ->campaign($campaign)
            ->application($application)
            ->process($request->only('action', 'reason'));

        return response()->json([$note]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function approve(ApproveApplication $request, Campaign $campaign, Application $application)
    {
        $this->authorize('applications', $campaign);

        if (! $campaign->canHaveMoreMembers()) {
            return response()->json(['Campaign is full, please boost it.']);
        }

        $request->merge(['action' => 'approve']);

        $note = $this->service
            ->user(auth()->user())
            ->campaign($campaign)
            ->application($application)
            ->process($request->only('role_id', 'action', 'reason'));

        return response()->json([$note]);
    }
}
