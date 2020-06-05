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
    protected $view = 'campaigns';

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
        // A user with campaigns doesn't need this process.
        if (Auth::user()->campaigns->count() > 0) {
            // Take the first campaign
            $campaign = Auth::user()->campaigns()->first();
            return redirect()->to(CampaignLocalization::getUrl($campaign->id));
        }
        $new = session()->has('user_registered');
        if ($new) {
            session()->remove('user_registered');
        }
        return view($this->view . '.create', [
            'start' => true,
            'tracking_new' => $new
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
        $user->welcome_campaign_id = $campaign->id;
        $user->save();

        if ($first) {
            return redirect()->route('home');
        }

        return redirect()->route('home')
            ->with('success', trans($this->view . '.create.' . ($first ? 'success_first_time' : 'success')));
    }
}
