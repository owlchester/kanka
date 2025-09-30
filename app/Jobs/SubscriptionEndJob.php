<?php

namespace App\Jobs;

use App\Events\Subscriptions\AutoRemove;
use App\Models\CampaignBoost;
use App\Models\Pledge;
use App\Models\Role;
use App\Models\User;
use App\Notifications\Header;
use App\Services\DiscordService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SubscriptionEndJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;

    public int $userId;

    public bool $cancelled;

    public bool $trial;

    public function __construct(User $user, bool $cancelled = false, bool $trial = false)
    {
        $this->userId = $user->id;
        $this->cancelled = $cancelled;
        $this->trial = $trial;
    }

    /**
     * A user has ended their subscription, either by cancelling or automatically by the script.
     * Let's send them a notification, update their discord roles, send an email, and update their user status
     */
    public function handle()
    {
        /** @var ?User $user */
        $user = User::find($this->userId);
        if (empty($user) || $this->userId == 27078 || $user->subscribed('kanka')) {
            // User deleted their account already or renewed their subscription.
            return;
        }

        // Cleanup the user
        $user->pledge = null;
        $settings = $user->settings;
        unset($settings['grandfathered_boost']);
        $user->settings = $settings;
        $user->saveQuietly();

        // Cleanup the campaign boosts
        $boostService = app()->make('App\Services\Campaign\BoostService');
        $unboostedCampaigns = [];
        /** @var CampaignBoost $boost */
        foreach ($user->boosts()->with(['campaign'])->get() as $boost) {
            $boostService
                ->campaign($boost->campaign)
                ->user($user)
                ->unboost($boost);
            if (! in_array($boost->campaign_id, $unboostedCampaigns)) {
                AutoRemove::dispatch($boost->campaign, $user);
                $unboostedCampaigns[] = $boost->campaign_id;
            }
        }

        // Cleanup the subscriber role
        /** @var Role $role */
        $role = Role::where('name', Pledge::ROLE)->first();
        $user->roles()->detach($role->id);

        // Notify the user in app about the change
        $key = 'subscriptions.' . ($this->trial ? 'trial' : ($this->cancelled ? 'failed' : 'ended'));
        $user->notify(
            new Header(
                $key,
                'fa-regular fa-gem',
                'orange'
            )
        );

        // Lastly, cleanup any discord stuff
        /** @var DiscordService $discord */
        $discord = app()->make('App\Services\DiscordService');
        try {
            $discord->user($user)->removeRoles();
        } catch (Exception $e) {
            Log::error('DiscordRoleJob:: ' . $e->getMessage());
            // Silence errors and ignore
        }
    }
}
