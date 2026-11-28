<?php

namespace App\Http\Controllers\Settings\Subscription;

use App\Exceptions\TranslatableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionPause;
use App\Services\Subscription\PauseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PauseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'identity', 'subscriptions']);
    }

    public function pause(SubscriptionPause $request, PauseService $service): RedirectResponse
    {
        try {
            $resumeAt = $service
                ->user($request->user())
                ->pause((int) $request->validated('months'));

            return redirect()
                ->route('settings.subscription')
                ->withSuccess(__('subscriptions/pause.success.paused', [
                    'date' => $resumeAt->isoFormat('MMMM D, Y'),
                ]));
        } catch (TranslatableException $e) {
            return redirect()
                ->route('settings.subscription')
                ->with('error_raw', $e->getTranslatedMessage());
        }
    }

    public function resume(Request $request, PauseService $service): RedirectResponse
    {
        try {
            $service
                ->user($request->user())
                ->resume();

            return redirect()
                ->route('settings.subscription')
                ->withSuccess(__('subscriptions/pause.success.resumed'));
        } catch (TranslatableException $e) {
            return redirect()
                ->route('settings.subscription')
                ->with('error_raw', $e->getTranslatedMessage());
        }
    }
}
