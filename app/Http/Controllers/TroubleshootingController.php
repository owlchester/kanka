<?php

namespace App\Http\Controllers;

use App\Exceptions\TranslatableException;
use App\Http\Requests\SaveUserHelp;
use App\Models\Campaign;
use App\Services\TroubleshootingService;

class TroubleshootingController extends Controller
{
    public function __construct(protected TroubleshootingService $service)
    {
        $this->middleware(['auth', 'identity']);
    }

    public function index()
    {
        $campaigns = $this->service
            ->user(auth()->user())
            ->campaigns();
        $token = session()->get('token');

        return view('helpers.troubleshooting.index')
            ->with(compact('campaigns', 'token'));
    }

    public function store(SaveUserHelp $request)
    {
        if (request()->ajax()) {
            return response()->json();
        }
        try {
            $campaign = Campaign::findOrFail($request->get('campaign'));
            $invite = $this->service
                ->user($request->user())
                ->campaign($campaign)
                ->generate();

            return redirect()
                ->route('troubleshooting')
                ->with('token', $invite->token);
        } catch (TranslatableException $e) {
            return redirect()
                ->route('troubleshooting')
                ->with('error_raw', $e->getTranslatedMessage());
        }
    }
}
