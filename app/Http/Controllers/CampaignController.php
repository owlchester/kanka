<?php

namespace App\Http\Controllers;

use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Models\Campaign;
use App\Http\Requests\StoreCampaign;
use App\Http\Requests\DeleteCampaign;
use App\Services\MultiEditingService;
use App\Services\CampaignService;
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
    protected string $view = 'campaigns';

    protected CampaignService $campaignService;

    /**
     * Create a new controller instance.
     *
     * CampaignController constructor.
     * @param CampaignService $campaignService
     */
    public function __construct(CampaignService $campaignService)
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'css']]);
        $this->campaignService = $campaignService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        return view($this->view . '.show', compact('campaign'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('create', $campaign);

        return view($this->view . '.create', ['start' => false]);
    }

    /**
     * @param StoreCampaign $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
            /** @var Campaign $campaign */
            $campaign = Campaign::create($data);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        if ($request->has('submit-update')) {
            return redirect()
                ->to($campaign->getLink('edit'))
                ->with('success', __($this->view . '.create.success'));
        } elseif ($request->has('submit-new')) {
            return redirect()
                ->route('start')
                ->with('success', __($this->view . '.create.success'));
        } elseif ($first) {
            $user = auth()->user();
            $user->save();
            return redirect()->route('dashboard', $campaign->id);
        }

        return redirect()->route('dashboard', $campaign->id)
            ->with('success', __($this->view . '.create.success'));
    }

    /**
     * @param Campaign $campaign
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Campaign $campaign)
    {
        return view($this->view . '.show', compact('campaign'));
    }

    /**
     * @param Campaign $campaign
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        /** @var MiscModel $model */
        $editingUsers = null;

        if ($campaign->hasEditingWarning()) {
            /** @var MultiEditingService $editingService */
            $editingService = app()->make(MultiEditingService::class);
            $editingUsers = $editingService->model($campaign)->user(auth()->user())->users();
            // If no one is editing the model, we are now editing it
            if (empty($editingUsers)) {
                $editingService->edit();
            }
        }
        return view($this->view . '.edit', [
            'model' => $campaign,
            'campaign' => $campaign,
            'start' => false,
            'editingUsers' => $editingUsers
        ]);
    }

    /**
     * @param StoreCampaign $request
     * @param Campaign $campaign
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Campaign $campaign, StoreCampaign $request)
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


        /** @var MultiEditingService $editingService */
        $editingService = app()->make(MultiEditingService::class);
        $editingService->model($campaign)
            ->user($request->user())
            ->finish();

        if ($request->has('submit-update')) {
            return redirect()
                ->route('edit', $campaign)
                ->with('success', __($this->view . '.edit.success'));
        }
        if ($request->has('submit-new')) {
            return redirect()
                ->route('start')
                ->with('success', __($this->view . '.edit.success'));
        }

        return redirect()->route('overview', $campaign)
            ->with('success', __($this->view . '.edit.success'));
    }

    /**
     * @param Campaign $campaign
     * @param DeleteCampaign $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, DeleteCampaign $request)
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
    public function css(Campaign $campaign)
    {
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
