<?php

namespace App\Http\Controllers;

use App\Exceptions\TranslatableException;
use App\Models\Campaign;
use App\Models\CampaignBoost;
use App\Services\CampaignBoostService;
use http\Client\Request;
use Illuminate\Foundation\Http\FormRequest;

class CampaignBoostController extends Controller
{
    /**
     * @var CampaignBoostService
     */
    protected $campaignBoostService;

    /**
     * CampaignBoostController constructor.
     * @param CampaignBoostService $campaignBoostService
     */
    public function __construct(CampaignBoostService $campaignBoostService)
    {
        $this->middleware(['auth', 'identity']);
        $this->campaignBoostService = $campaignBoostService;
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
        $this->authorize('access', $campaign);

        try {
            $this->campaignBoostService->boost($campaign);

            return redirect()
                ->route('settings.boost')
                ->with('success', trans('settings.boost.success.boost', ['name' => $campaign->name]));
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

        $campaignBoost->delete();
        return redirect()
            ->route('settings.boost')
            ->with('success', __('settings.boost.success.delete', ['name' => $campaignBoost->campaign->name]));
    }
}