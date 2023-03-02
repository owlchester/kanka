<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Services\PatreonService;
use Illuminate\Http\Request;

class PatreonController extends Controller
{
    /**
     * @var PatreonService
     */
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @param PatreonService $service
     * @return void
     */
    public function __construct(PatreonService $service)
    {
        $this->middleware(['auth', 'identity']);
        $this->service = $service;
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
    public function unlink(Request $request)
    {
        $this->service->user($request->user())->unlink();
        return redirect()->route('settings.patreon')
            ->with('success', __('settings.patreon.remove.success'));
    }
}
