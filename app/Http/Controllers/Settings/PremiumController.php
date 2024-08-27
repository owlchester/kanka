<?php

namespace App\Http\Controllers\Settings;

use App\Exceptions\TranslatableException;
use App\Facades\CampaignCache;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Campaign\BoostService;
use App\Models\User;

class PremiumController extends Controller
{
    protected BoostService $service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BoostService $campaignBoostService)
    {
        $this->middleware(['auth', 'identity']);
        $this->service = $campaignBoostService;
    }

    public function index()
    {
        if (auth()->user()->hasBoosterNomenclature()) {
            return redirect()->route('settings.boost');
        }

        // If a campaign was provided, make sure we have access to it
        $campaignId = request()->get('campaign');
        $campaign = null;

        /** @var User $user */
        $user = auth()->user();
        $premiums = $user->boosts()->with(['campaign', 'campaign.boosts', 'campaign.boosts.user'])->groupBy('campaign_id')->get();
        $userCampaigns = $user->campaigns()->with(['boosts', 'boosts.user'])->unboosted()->whereNotIn('campaigns.id', $premiums->pluck('campaign_id'))->get();

        if (!empty($campaignId)) {
            /** @var Campaign $campaign */
            $campaign = Campaign::where(['id' => (int)$campaignId])->firstOrFail();
            CampaignCache::campaign($campaign);
            $this->authorize('access', $campaign);

            if ($campaign->premium()) {
                return redirect()
                    ->route('settings.premium');
            }

            $userCampaigns = $userCampaigns->where('id', '!=', $campaignId);
        }

        return view('settings.premium.index')
            ->with('campaigns', $userCampaigns)
            ->with('premiums', $premiums)
            ->with('focus', $campaign)
        ;
    }

    /**
     * Migrate a user to the new system
     * @return \Illuminate\Http\RedirectResponse
     */
    public function migrate()
    {
        try {
            $this->service
                ->user(auth()->user())
                ->migrate();

            return redirect()->route('settings.premium')
                ->with('success', __('Thanks for switching to our premium campaigns!'));
        } catch (TranslatableException $ex) {
            return redirect()
                ->route('settings.boost')
                ->with('error', __($ex->getMessage()));
        }
    }

    /**
     * For local debugging
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function back()
    {
        if (!app()->environment('local')) {
            return redirect()->route('settings.premium');
        }

        $this->service
            ->user(auth()->user())
            ->back();

        return redirect()->route('settings.boost')
            ->with('success', __('Migrated back'));
    }
}
