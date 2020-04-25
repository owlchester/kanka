<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingsProfile;
use App\Services\PatreonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatreonController extends Controller
{
    /**
     * @var PatreonService
     */
    protected $patreon;

    /**
     * Create a new controller instance.
     *
     * @param PatreonService $patreon
     * @return void
     */
    public function __construct(PatreonService $patreon)
    {
        $this->middleware(['auth', 'identity', 'shadow']);
        $this->patreon = $patreon;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('settings.patreon');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback(Request $request)
    {
        try {
            $this->patreon->user(auth()->user())->link($request->get('code', false));
            return redirect()->route('settings.patreon')
                ->with('success', trans('settings.patreon.success'));
        } catch (\Exception $e) {
            return redirect()->route('settings.patreon')
                ->withErrors(
                    trans('settings.patreon.errors.' . $e->getMessage())
                );
        }
    }

    public function unlink(Request $request)
    {
        $this->patreon->user($request->user())->unlink();
        return redirect()->route('settings.patreon')
            ->with('success', trans('settings.patreon.remove.success'));

    }
}
