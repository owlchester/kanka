<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Facades\CampaignLocalization;
use App\Http\Requests\StoreCampaign;
use App\Services\CampaignService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
        if (Auth::user()->hasCampaigns()) {
            // Take the first campaign
            $campaign = Auth::user()->campaigns()->first();
            return redirect()->to(CampaignLocalization::getUrl($campaign->id));
        }
        return view($this->view . '.create', ['start' => true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCampaign $request)
    {
        $this->authorize('create', 'App\Campaign');

        $first = Auth::user()->hasCampaigns();
        Campaign::create($request->all());
        return redirect()->route('home')
            ->with('success', trans($this->view . '.create.' . ($first ? 'success_first_time' : 'success')));
    }
}
