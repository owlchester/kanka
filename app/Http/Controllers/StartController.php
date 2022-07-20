<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Facades\CampaignLocalization;
use App\Http\Requests\StoreCampaign;
use App\Services\CampaignService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StartController extends Controller
{
    /**
     * @var string
     */
    protected string $view = 'campaigns';

    /**
     * Create a new controller instance.
     *
     * CampaignController constructor.
     * @param CampaignService $campaignService
     */
    public function __construct(CampaignService $campaignService)
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCampaign $request)
    {
        $this->authorize('create', 'App\Models\Campaign');

        $first = !Auth::user()->hasCampaigns();
        $options = $request->all();
        $options['entry'] = '';
        $options['excerpt'] = '';
        $campaign = Campaign::create($options);

        $user = auth()->user();
        $user->save();

        if ($first) {
            return redirect()->route('home');
        }

        return redirect()->route('home')
            ->with('success', trans($this->view . '.create.' . ($first ? 'success_first_time' : 'success')));
    }
}
