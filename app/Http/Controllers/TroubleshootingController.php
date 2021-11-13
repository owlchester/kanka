<?php

namespace App\Http\Controllers;

use App\Exceptions\TranslatableException;
use App\Http\Requests\SaveUserHelp;
use App\Services\TroubleshootingService;

class TroubleshootingController extends Controller
{
    /** @var TroubleshootingService */
    protected $service;

    public function __construct(TroubleshootingService $service)
    {
        $this->middleware(['auth', 'identity']);

        $this->service = $service;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function invite()
    {
        $campaigns = $this->service
            ->user(auth()->user())
            ->campaigns();
        $token = session()->get('token');

        return view('helpers.troubleshooting.index')
            ->with(compact('campaigns', 'token'));
    }

    /**
     * @param SaveUserHelp $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveInvite(SaveUserHelp $request)
    {
        try {
            $invite = $this->service
                ->user(auth()->user())
                ->campaign($request->get('campaign'))
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
