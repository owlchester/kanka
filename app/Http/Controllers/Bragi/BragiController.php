<?php

namespace App\Http\Controllers\Bragi;

use App\Http\Controllers\Controller;
use App\Http\Requests\BragiRequest;
use App\Models\Campaign;
use App\Services\Bragi\BragiService;

class BragiController extends Controller
{
    public function __construct(protected BragiService $service)
    {
        $this->middleware('auth');
    }

    public function index(Campaign $campaign)
    {
        return response()->json(
            $this->service
                ->campaign($campaign)
                ->user(auth()->user())
                ->prepare()
        );
    }

    public function generate(BragiRequest $request, Campaign $campaign)
    {
        return response()->json(
            $this->service
                ->user($request->user())
                ->campaign($campaign)
                ->generate($request)
        );
    }
}
