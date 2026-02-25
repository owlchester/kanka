<?php

namespace App\Http\Controllers\Onboarding;

use App\Http\Controllers\Controller;
use App\Http\Requests\Onboarding\InitialRequest;
use App\Models\Campaign;
use App\Services\Onboarding\InitialService;
use Illuminate\Http\Request;

class InitialController extends Controller
{
    public function __construct(protected InitialService $initialService) {}

    public function save(InitialRequest $request, Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        $this->initialService
            ->campaign($campaign)
            ->user(auth()->user())
            ->request($request)
            ->save();

        return response()->json([
            'success' => true,
            'redirect' => route('home', $campaign),
        ]);
    }

    public function skip(Request $request, Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        $this->initialService
            ->campaign($campaign)
            ->user(auth()->user())
            ->skip($request->get('reason', 'skip'));

        return response()->json([
            'success' => true,
        ]);
    }
}
