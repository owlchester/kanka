<?php

namespace App\Http\Controllers\Settings\Subscription;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Subscription\TrialService;
use Illuminate\Http\Request;

class FreeTrialController extends Controller
{
    public function __construct(
        protected TrialService $trialService
    ) {
        $this->middleware(['auth', 'identity', 'subscriptions']);
    }

    public function index(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $this->authorize('free-trial', $user);


        return view('settings.subscription.free-trial', compact(
            'user',
        ));
    }

    public function accept(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $this->authorize('free-trial', $user);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        $this->trialService->user($user)->accept();

        return redirect()->route('settings.subscription.finish', ['trial' => 1]);
    }
}
