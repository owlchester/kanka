<?php

namespace App\Http\Controllers;

use App\Exceptions\TranslatableException;
use App\Facades\CampaignCache;
use App\Models\Campaign;
use App\Models\CampaignBoost;
use App\Services\Campaign\BoostService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CampaignBoostController extends Controller
{
    protected BoostService $campaignBoostService;

    public function __construct(BoostService $campaignBoostService)
    {
        $this->middleware(['auth', 'identity']);
        $this->campaignBoostService = $campaignBoostService;
    }

    public function create()
    {
        $campaignID = request()->get('campaign');
        $campaign = Campaign::where('slug', $campaignID)->firstOrFail();
        $user = auth()->user();
        if ($user->hasBoosterNomenclature()) {
            $superboost = request()->has('superboost');
            $cost = $superboost ? 3 : 1;

            return view('settings.boosters.create')
                ->with('campaign', $campaign)
                ->with('superboost', $superboost)
                ->with('cost', $cost)
                ->with('user', $user);
        }

        if (!$campaign->boosted() && $user->availableBoosts() < 1 && !auth()->user()->can('boost', $user)) {
            return view('layouts.dialogs.subscription', [
                'title' => __('settings/premium.ready.title'),
                'campaign' => $campaign,
            ]);
        }

        return view('settings.premium.create')
            ->with('campaign', $campaign)
            ->with('user', $user);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
        $campaignId = $request->get('campaign_id');
        /** @var Campaign $campaign */
        $campaign = Campaign::findOrFail($campaignId);
        CampaignCache::campaign($campaign);
        $this->authorize('access', $campaign);

        if ($request->ajax()) {
            return response()->json();
        }

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
                CampaignCache::campaign($campaign)->clearSidebar()->clear();

                $superboost = $action == 'superboost';

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
            CampaignCache::campaign($campaign)->clearSidebar()->clear();

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

        if (! auth()->user()->hasBoosterNomenclature()) {
            return redirect()->route('settings.premium');
        }

        return view('settings.boosters.update')
            ->with('boost', $campaignBoost)
            ->with('campaign', $campaignBoost->campaign)
            ->with('cost', 2);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(Request $request, CampaignBoost $campaignBoost)
    {
        if (! auth()->user()->hasBoosterNomenclature()) {
            return redirect()->route('settings.premium');
        }
        $campaign = $campaignBoost->campaign;

        // If the user created the boost, allow them to update it. We don't check the campaign because there is
        // no campaign in the url.
        $this->authorize('destroy', $campaignBoost);
        if ($request->ajax()) {
            return response()->json();
        }

        try {
            $this->campaignBoostService
                ->user(auth()->user())
                ->campaign($campaign)
                ->upgrade()
                ->action($request->post('action'))
                ->boost();

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
     * @return Application|Factory|View
     *
     * @throws AuthorizationException
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
     * @throws AuthorizationException
     */
    public function destroy(CampaignBoost $campaignBoost)
    {
        $this->authorize('destroy', $campaignBoost);
        if (request()->ajax()) {
            return response()->json();
        }
        $this->campaignBoostService
            ->user(auth()->user())
            ->campaign($campaignBoost->campaign)
            ->unboost($campaignBoost);
        CampaignCache::campaign($campaignBoost->campaign)->clearSidebar()->clear();

        if (auth()->user()->hasBoosterNomenclature()) {
            return redirect()
                ->route('settings.boost')
                ->with('success_raw', __('settings/boosters.unboost.success', ['campaign' => $campaignBoost->campaign->name]));
        }

        return redirect()
            ->route('settings.premium')
            ->with('success_raw', __('settings/premium.remove.success', ['campaign' => $campaignBoost->campaign->name]));
    }
}
