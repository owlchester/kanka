<?php

namespace App\Http\Controllers\Settings\Subscription;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionCancel;
use App\Services\Subscription\CancellationService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CancellationController extends Controller
{
    public function __construct(
        protected CancellationService $service,
    ) {
        $this->middleware(['auth', 'identity', 'subscriptions']);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        if ($user->hasPayPal() || $user->subscription('kanka')?->onGracePeriod()) {
            return view('settings.subscription.cancellation.grace', compact(
                'user',
            ));
        }

        // Loss data
        $premiumCampaign = null;
        $members = new Collection();
        $plugins = 0;
        $premiumCampaigns = $user->boosts()
            ->with([
                'campaign' => function ($sub) { return $sub->select('campaigns.id', 'campaigns.name'); },
                'campaign.members',
                'campaign.plugins',
            ])
            ->groupBy('campaign_id')->get();
        foreach ($premiumCampaigns as $campaign) {
            if (!$premiumCampaign) {
                $premiumCampaign = $campaign->campaign;
                foreach ($campaign->campaign->members as $member) {
                    $members->push($member->user_id);
                }
                $plugins += $campaign->campaign->plugins->count();
            }
        }
        $members = $members->unique();
        $userId = auth()->user()->id;
        $players = $members->reject(fn($userId) => $userId == $user->id)->count();

        $discord = auth()->user()->discord();



        return view('settings.subscription.cancellation.form', compact(
            'user',
            'premiumCampaigns',
            'premiumCampaign',
            'players',
            'discord',
            'plugins',
        ));
    }

    public function save(SubscriptionCancel $request)
    {
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        $this->service
            ->user($request->user())
            ->request($request)
            ->cancel();

        return redirect()
            ->route('settings.subscription.cancelled', ['cancelled' => 1])
            ->with('sub_tracking', 'cancel')
            ->with('sub_value', 0);
    }
}
