<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\EntityResource as Resource;
use App\Models\Campaign;
use Illuminate\Support\Facades\DB;

class RecentEntityApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        if (config('app.debug')) {
            DB::enableQueryLog();
        }

        $this->authorize('access', $campaign);

        return Resource::collection(
            $campaign->entities()
                ->apiFilter($campaign, request()->all())
                ->orderBy('updated_at', 'DESC')
                ->limit(min(max(1, request()->get('amount')), 10))
                ->lastSync(request()->get('lastSync'))
                ->get()
        );
    }
}
