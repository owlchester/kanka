<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Http\Requests\StoreCampaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StartController extends Controller
{
    protected string $view = 'campaigns';

    /**
     * Create a new controller instance.
     *
     * CampaignController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $campaign = new Campaign();
        $this->authorize('create', $campaign);

        // A user with campaigns doesn't need this process.
        $tracking = null;
        if (session()->has('user_registered')) {
            session()->remove('user_registered');
            $tracking = 'pa10CJTvrssBEOaOq7oC';
        }
        return view($this->view . '.create', [
            'start' => auth()->user()->campaigns->count() === 0,
            'gaTrackingEvent' => $tracking,
        ]);
    }

    /**
     * @param StoreCampaign $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreCampaign $request)
    {
        $this->authorize('create', 'App\Models\Campaign');

        $first = !Auth::user()->hasCampaigns();
        $options = $request->all();
        $options['entry'] = '';
        $options['excerpt'] = '';
        Campaign::create($options);

        if ($first) {
            return redirect()->route('home');
        }

        return redirect()->route('home')
            ->with('success', __($this->view . '.create.success'));
    }
}
