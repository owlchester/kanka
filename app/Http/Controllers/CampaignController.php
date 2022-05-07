<?php

namespace App\Http\Controllers;

use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Models\Campaign;
use App\Http\Requests\StoreCampaign;
use App\Models\UserLog;
use App\Services\CampaignService;
use App\Services\EntityService;
use App\Services\StarterService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
    /**
     * @var string
     */
    protected $view = 'campaigns';

    /** @var CampaignService  */
    protected $campaignService;

    /** @var EntityService  */
    protected $entityService;

    /** @var StarterService  */
    protected $starterService;

    /**
     * Create a new controller instance.
     *
     * CampaignController constructor.
     * @param CampaignService $campaignService
     */
    public function __construct(CampaignService $campaignService, EntityService $entityService, StarterService $starterService)
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'css']]);
        $this->campaignService = $campaignService;
        $this->entityService = $entityService;
        $this->starterService = $starterService;
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
        $campaign = new Campaign();
        $this->authorize('create', $campaign);


        $first = !auth()->user()->hasCampaigns();
        $data = $request->all();

        $data['entry'] = Arr::get($data, 'entry');
        $data['excerpt'] = Arr::get($data, 'excerpt');

        DB::beginTransaction();
        try {
            $campaign = Campaign::create($data);
            auth()->user()->setCurrentCampaign($campaign);

            // If it's the first campaign for the user, generate some boilerplate content
            /*if ($first) {
                CampaignLocalization::forceCampaign($campaign);
                $this->starterService->generateBoilerplate($campaign);
            }*/

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        if ($request->has('submit-update')) {
            return redirect()
                ->to(app()->getLocale() . '/campaign/' . $campaign->id . '/campaigns/' . $campaign->id . '/edit')
                ->with('success', __($this->view . '.create.success'));
        }
        elseif ($request->has('submit-new')) {
            return redirect()
                ->route('start')
                ->with('success', __($this->view . '.create.success'));
        }
        elseif ($first) {
            $user = auth()->user();
            $user->welcome_campaign_id = $campaign->id;
            $user->save();
            return redirect()->to(app()->getLocale() . '/' . $campaign->getMiddlewareLink());
        }

        return redirect()->to(app()->getLocale() . '/' . $campaign->getMiddlewareLink())
            ->with('success', __($this->view . '.create.success'));
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

        $data = $request->all();
        // Missing sidebar config? Because we shouldn't have used the same array...
        if (!empty($campaign->ui_settings['sidebar'])) {
            $data['ui_settings']['sidebar'] = $campaign->ui_settings['sidebar'];
        }
        // Also, let's unset ui_settings that are set to true
        foreach ($data['ui_settings'] as $key => $value) {
            if ($value === '0') {
                unset($data['ui_settings'][$key]);
            }
        }

        $campaign->update($data);

        if ($request->has('submit-update')) {
            return redirect()
                ->route('campaigns.edit', $campaign)
                ->with('success', __($this->view . '.edit.success'));
        }
        if ($request->has('submit-new')) {
            return redirect()
                ->route('start')
                ->with('success', __($this->view . '.edit.success'));
        }

        return redirect()->route('campaign')
            ->with('success', __($this->view . '.edit.success'));
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

        $this->campaignService->delete($campaign);

        return redirect()->route('home');
    }

    /**
     * Leave a campaign
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function leave()
    {
        $campaign = CampaignLocalization::getCampaign();
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
        if ($campaign->boosted()) {
            $css = CampaignCache::styles();
        }

        $response = \Illuminate\Support\Facades\Response::make($css);
        $response->header('Content-Type', 'text/css');
        $response->header('Expires', Carbon::now()->addMonth()->toDateTimeString());
        $month = 2592000;
        $response->header('Cache-Control', 'public, max_age=' . $month);

        return $response;
    }
}
