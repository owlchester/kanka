<?php

namespace App\Http\Controllers;

use App\Facades\CampaignLocalization;
use App\Models\Campaign;
use App\Http\Requests\StoreCampaign;
use App\Services\CampaignService;
use App\Services\EntityService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CampaignController extends Controller
{
    /**
     * @var string
     */
    protected $view = 'campaigns';

    /**
     * @var CampaignService
     */
    protected $campaignService;

    /**
     * @var EntityService
     */
    protected $entityService;

    /**
     * Create a new controller instance.
     *
     * CampaignController constructor.
     * @param CampaignService $campaignService
     */
    public function __construct(CampaignService $campaignService, EntityService $entityService)
    {
        $this->middleware('auth', ['except' => ['show', 'css']]);
        $this->campaignService = $campaignService;
        $this->entityService = $entityService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $campaign = CampaignLocalization::getCampaign();
        return view($this->view . '.show', compact('campaign'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('create', $campaign);

        return view($this->view . '.create', ['start' => false]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCampaign $request)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('create', $campaign);

        $first = !Auth::user()->hasCampaigns();
        $campaign = Campaign::create($request->all());
        if ($first) {
            $user = auth()->user();
            $user->welcome_campaign_id = $campaign->id;
            $user->save();
            return redirect()->route('home');
        }
        return redirect()->route('home')->with('success', trans($this->view . '.create.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign)
    {
        return view($this->view . '.show', compact('campaign'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        return view($this->view . '.edit', ['model' => $campaign, 'start' => false]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCampaign $request, Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        $campaign->update($request->all());
        return redirect()->route('campaign')
            ->with('success', trans($this->view . '.edit.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign)
    {
        $this->authorize('delete', $campaign);

        $campaign->delete();
        CampaignService::switchToNext();

        return redirect()->route('home');
    }

    /**
     * @param Campaign $campaign
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function leave(Campaign $campaign)
    {
        $this->authorize('leave', $campaign);

        try {
            $this->campaignService->leave($campaign);
            return redirect()->route('home');
        } catch (\Exception $e) {
            return redirect()->route('campaign')->withErrors($e->getMessage());
        }
    }

    /**
     * Get the campaign css
     * @return Response
     */
    public function css()
    {
        $campaign = CampaignLocalization::getCampaign();
        $css = null;
        if ($campaign->boosted() && !empty($campaign->css)) {
            $css = $campaign->css;
        }

        $response = \Illuminate\Support\Facades\Response::make($css);
        $response->header('Content-Type', 'text/css');
        $response->header('Expires', Carbon::now()->addMonth(1)->toDateTimeString());
        $month = 2592000;
        $response->header('Cache-Control', 'public, max_age=' . $month);

        return $response;
    }
}
