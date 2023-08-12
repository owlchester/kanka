<?php

namespace App\Http\Controllers;

use App\Exceptions\TranslatableException;
use App\Facades\CampaignCache;
use App\Models\Campaign;
use App\Models\CampaignBoost;
use App\Services\Campaign\NotificationService;
use App\Services\CampaignBoostService;

class CampaignBoostController extends Controller
{
    protected CampaignBoostService $campaignBoostService;

    protected NotificationService $notificationService;

    public function __construct(CampaignBoostService $campaignBoostService, NotificationService $notificationService)
    {
        $this->middleware(['auth', 'identity']);
        $this->campaignBoostService = $campaignBoostService;
        $this->notificationService = $notificationService;
    }

    public function create()
    {
        $campaignID = request()->get('campaign');
        $campaign = Campaign::findOrFail($campaignID);
        $user = auth()->user();
        if ($user->hasBoosterNomenclature()) {
            $superboost = request()->has('superboost');
            $cost = $superboost ? 3 : 1;

            return view('settings.boosters.create')
                ->with('campaign', $campaign)
                ->with('superboost', $superboost)
                ->with('cost', $cost)
                ->with('user', $user)
            ;
        }

        return view('settings.premium.create')
            ->with('campaign', $campaign)
            ->with('user', $user)
        ;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(\Illuminate\Http\Request $request)
    {
        $campaignId = $request->get('campaign_id');
        /** @var Campaign $campaign */
        $campaign = Campaign::findOrFail((int) $campaignId);
        CampaignCache::campaign($campaign);
        $this->authorize('access', $campaign);

        if (auth()->user()->hasBoosterNomenclature()) {
            try {
                $action = $request->post('action');
                if ($request->has('superboost')) {
                    $action = 'superboost';
                }
                $this->campaignBoostService
                    ->user(auth()->user())
                    ->campaign($campaign)
                    ->action($action)
                    ->boost();

                $superboost = $action == 'superboost';

                $this->notificationService
                    ->campaign($campaign)
                    ->notify(
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

        try {
            $this->campaignBoostService
                ->user(auth()->user())
                ->campaign($campaign)
                ->premium();

            $this->notificationService
                ->campaign($campaign)
                ->notify(
                    'premium.add',
                    'rocket',
                    'maroon',
                    [
                        'user' => auth()->user()->name,
                        'campaign' => $campaign->name
                    ]
                );

            return redirect()
                ->route('settings.premium')
                ->with('success_raw', __('settings/premium.create.success', ['campaign' => $campaign->name]));
        } catch (TranslatableException $e) {
            return redirect()
                ->route('settings.premium')
                ->with('error', $e->getTranslatedMessage());
        }
    }

    public function show(CampaignBoost $campaignBoost)
    {
        return redirect()->route('settings.boost');
    }

    public function edit(CampaignBoost $campaignBoost)
    {
        $this->authorize('destroy', $campaignBoost);

        if (!auth()->user()->hasBoosterNomenclature()) {
            return redirect()->route('settings.premium');
        }

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
    public function update(\Illuminate\Http\Request $request, CampaignBoost $campaignBoost)
    {
        if (!auth()->user()->hasBoosterNomenclature()) {
            return redirect()->route('settings.premium');
        }
        $campaign = $campaignBoost->campaign;

        // If the user created the boost, allow them to update it. We don't check the campaign because there is
        // no campaign in the url.
        $this->authorize('destroy', $campaignBoost);

        try {
            $this->campaignBoostService
                ->user(auth()->user())
                ->campaign($campaign)
                ->upgrade()
                ->action($request->post('action'))
                ->boost();

            $this->notificationService
                ->campaign($campaign)
                ->notify(
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

        if (auth()->user()->hasBoosterNomenclature()) {
            return view('settings.boosters.unboost')
                ->with('campaign', $campaignBoost->campaign)
                ->with('boost', $campaignBoost);
        }
        return view('settings.premium.remove')
            ->with('campaign', $campaignBoost->campaign)
            ->with('boost', $campaignBoost);
    }

    /**
     * @param CampaignBoost $campaignBoost
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(CampaignBoost $campaignBoost)
    {
        $this->authorize('destroy', $campaignBoost);
        $this->campaignBoostService
            ->user(auth()->user())
            ->campaign($campaignBoost->campaign)
            ->unboost($campaignBoost);

        if (auth()->user()->hasBoosterNomenclature()) {
            $this->notificationService
                ->campaign($campaignBoost->campaign)
                ->notify(
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

        $this->notificationService
            ->campaign($campaignBoost->campaign)
            ->notify(
                'premium.remove',
                'rocket',
                'red',
                [
                    'user' => auth()->user()->name,
                    'campaign' => $campaignBoost->campaign->name
                ]
            );

        return redirect()
            ->route('settings.premium')
            ->with('success_raw', __('settings/premium.remove.success', ['campaign' => $campaignBoost->campaign->name]));
    }
}
