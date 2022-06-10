<?php

namespace App\Http\Controllers;

use App\Exceptions\TranslatableException;
use App\Facades\CampaignCache;
use App\Models\Campaign;
use App\Models\CampaignBoost;
use App\Services\CampaignBoostService;
use App\Services\CampaignService;

class CampaignBoostController extends Controller
{
    /**
     * @var CampaignBoostService
     */
    protected $campaignBoostService;

    /**
     * @var CampaignService
     */
    protected $campaignService;

    /**
     * CampaignBoostController constructor.
     * @param CampaignBoostService $campaignBoostService
     */
    public function __construct(CampaignBoostService $campaignBoostService, CampaignService $campaignService)
    {
        $this->middleware(['auth', 'identity']);
        $this->campaignBoostService = $campaignBoostService;
        $this->campaignService = $campaignService;
    }

    public function create()
    {
        $campaignID = request()->get('campaign');
        $campaign = Campaign::findOrFail($campaignID);
        $superboost = request()->has('superboost');
        $cost = $superboost ? 3 : 1;

        // Check if the campaign is already boosted
        if (!$campaign) {
            abort(404);
        }

        return view('settings.boosters.create')
            ->with('campaign', $campaign)
            ->with('superboost', $superboost)
            ->with('cost', $cost)
            ->with('user', auth()->user())
        ;
    }

    /**
     * @param $campaign
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(\Illuminate\Http\Request $request)
    {
        $campaignId = $request->get('campaign_id');
        $campaign = Campaign::findOrFail((int) $campaignId);
        CampaignCache::campaign($campaign);
        $this->authorize('access', $campaign);

        try {
            $this->campaignBoostService
                ->campaign($campaign)
                ->action($request->post('action'))
                ->boost();

            $superboost = $request->post('action') == 'superboost';

            $this->campaignService->notify(
                $campaign,
                'boost.' . ($superboost ? 'superboost' : 'add'),
                'rocket',
                'maroon',
                [
                    'user' => auth()->user()->name,
                    'campaign' => $campaign->name
                ]
            );

            return redirect()
                ->route('settings.boost')
                ->with('success_raw', __('settings/boosters.' . ($superboost ? 'superboost' : 'boost') . '.success', ['campaign' => $campaign->name]));
        } catch (TranslatableException $e) {
            return redirect()
                ->route('settings.boost')
                ->with('error', $e->getTranslatedMessage());
        }
    }

    public function edit(CampaignBoost $campaignBoost)
    {
        $this->authorize('destroy', $campaignBoost);

        return view('settings.boosters.update')
            ->with('boost', $campaignBoost)
            ->with('campaign', $campaignBoost->campaign)
            ->with('cost', 2)
        ;
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @param CampaignBoost $campaignBoost
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(\Illuminate\Http\Request $request, CampaignBoost $campaignBoost) {
        $campaign = $campaignBoost->campaign;

        // If the user created the boost, allow them to update it. We don't check the campaign because there is
        // no campaign in the url.
        $this->authorize('destroy', $campaignBoost);

        try {
            $this->campaignBoostService
                ->campaign($campaign)
                ->upgrade()
                ->boost();

            $this->campaignService->notify(
                $campaign,
                'boost.superboost',
                'rocket',
                'maroon',
                [
                    'user' => auth()->user()->name,
                    'campaign' => $campaign->name
                ]
            );

            return redirect()
                ->route('settings.boost')
                ->with('success_raw', __('settings/boosters.superboost.success', ['campaign' => $campaign->name]));
        } catch (TranslatableException $e) {
            return redirect()
                ->route('settings.boost')
                ->with('error', $e->getTranslatedMessage());
        }
    }


    /**
     * @param CampaignBoost $campaignBoost
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function confirm(CampaignBoost $campaignBoost)
    {
        $this->authorize('destroy', $campaignBoost);

        return view('settings.boosters.unboost')
            ->with('campaign', $campaignBoost->campaign)
            ->with('boost', $campaignBoost)
            ;
    }

    /**
     * @param CampaignBoost $campaignBoost
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(CampaignBoost $campaignBoost)
    {
        $this->authorize('destroy', $campaignBoost);

        $this->campaignBoostService->campaign($campaignBoost->campaign)->unboost($campaignBoost);

        $this->campaignService->notify(
            $campaignBoost->campaign,
            'boost.remove',
            'rocket',
            'red',
            [
                'user' => auth()->user()->name,
                'campaign' => $campaignBoost->campaign->name
            ]
        );


        return redirect()
            ->route('settings.boost')
            ->with('success_raw', __('settings/boosters.unboost.success', ['campaign' => $campaignBoost->campaign->name]));
    }
}
