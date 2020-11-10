<?php

namespace App\Http\Controllers;

use App\Exceptions\TranslatableException;
use App\Facades\CampaignCache;
use App\Models\Campaign;
use App\Models\CampaignBoost;
use App\Services\CampaignBoostService;
use App\Services\CampaignService;
use Illuminate\Support\Facades\Auth;

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
                    'user' => e(Auth::user()->name),
                    'campaign' => e($campaign->name)
                ]
            );

            return redirect()
                ->route('settings.boost')
                ->with('success', trans('settings.boost.success.' . ($superboost ? 'superboost' : 'boost'), ['name' => $campaign->name]));
        } catch (TranslatableException $e) {
            return redirect()
                ->route('settings.boost')
                ->with('error', $e->getTranslatedMessage());
        }
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
                    'user' => e(Auth::user()->name),
                    'campaign' => $campaign->name
                ]
            );

            return redirect()
                ->route('settings.boost')
                ->with('success', trans('settings.boost.success.superboost', ['name' => $campaign->name]));
        } catch (TranslatableException $e) {
            return redirect()
                ->route('settings.boost')
                ->with('error', $e->getTranslatedMessage());
        }
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
                'user' => e(Auth::user()->name),
                'campaign' => e($campaignBoost->campaign->name)
            ]
        );


        return redirect()
            ->route('settings.boost')
            ->with('success', __('settings.boost.success.delete', ['name' => $campaignBoost->campaign->name]));
    }
}
