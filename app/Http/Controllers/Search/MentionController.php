<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Http\Requests\Search\MentionRequest;
use App\Models\Campaign;
use Illuminate\Http\Request;

class MentionController extends Controller
{
    public function __construct(protected \App\Services\Search\MentionService $service) {}

    public function index(Request $request, Campaign $campaign)
    {
        $this->authorize('member', $campaign);

        $this->service
            ->user(auth()->user())
            ->request($request)
            ->campaign($campaign);

        return response()->json(
            $this->service->search()
        );
    }

    public function load(MentionRequest $request, Campaign $campaign)
    {
        $this->authorize('member', $campaign);

        $this->service
            ->user(auth()->user())
            ->request($request)
            ->campaign($campaign);

        return response()->json(
            $this->service->load()
        );
    }
}
