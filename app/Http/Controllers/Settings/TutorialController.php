<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Services\TutorialService;

class TutorialController extends Controller
{
    protected TutorialService $service;

    public function __construct(TutorialService $service)
    {
        $this->middleware(['auth', 'identity']);
        $this->service = $service;
    }

    public function reset()
    {
        if (app()->isProduction()) {
            abort(404);
        }
        $this->service
            ->user(auth()->user())
            ->reset();

        return redirect()->route('settings.profile')
            ->with('success', __('Tutorials reset'));
    }

    public function dismiss(string $code)
    {
        $this->service
            ->user(auth()->user())
            ->track($code);

        return response()->json(['success', true]);
    }
}
