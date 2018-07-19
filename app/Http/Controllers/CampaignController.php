<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Http\Requests\StoreCampaign;
use App\Services\CampaignService;
use App\Services\EntityService;
use Illuminate\Http\Request;
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
        $this->middleware('auth');
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
        // If the user has no campaigns, we'll need to move him to the new campaign interface first.
        if (Auth::user()->campaigns()->count() == 0) {
            return redirect()->route('campaigns.create');
        }

        $active = Session::get('campaign_id');
        $campaigns = null;
        $campaign = null;
        if (!empty($active)) {
            $campaigns = Campaign::whereHas('users', function ($q) { $q->where('users.id', Auth::user()->id); })->where('id', '!=', $active)->get();
            $campaign = Auth::user()->campaign;
        } else {
            $campaigns = Campaign::whereHas('users', function ($q) { $q->where('users.id', Auth::user()->id); })->get();
        }

        return view($this->view . '.index', compact('campaigns', 'campaign', 'active'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->view . '.create');
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

        $first = !Session::has('campaign_id');
        Campaign::create($request->all());
        return redirect()->to('/')
            ->with('success', trans($this->view . '.create.' . ($first ? 'success_first_time' : 'success')));
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

        return view($this->view . '.edit', ['model' => $campaign]);
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
        return redirect()->route('campaigns.index')
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
            return redirect()->route('campaigns.index')->withErrors($e->getMessage());
        }
    }

    /**
     * @param Campaign $campaign
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function export(Campaign $campaign)
    {
        $this->authorize('setting', $campaign);

        try {
            $this->campaignService->export($campaign, Auth::user(), $this->entityService);
            return redirect()->route('campaigns.index', '#tab_export')
                ->with('success', trans('campaigns.export.success'));
        } catch (\Exception $e) {
            return redirect()->route('campaigns.index', '#tab_export')->withErrors($e->getMessage());
        }
    }
}
