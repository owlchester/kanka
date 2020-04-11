<?php


namespace App\Jobs;


use App\Mail\Subscription\Admin\CancelledSubscriptionMail;
use App\Notifications\Header;
use App\Services\DiscordService;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use TCG\Voyager\Models\Role;

class SubscriptionEndJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var User  */
    public $userId;

    /** @var bool */
    public $cancelled;

    public function __construct(User $user, bool $cancelled = false)
    {
        $this->userId = $user->id;
        $this->cancelled = $cancelled;
    }

    /**
     * A user has ended their subscription, either by cancelling or automatically by the script.
     * Let's send them a notification, update their discord roles, send an email, and update their user status
     */
    public function handle()
    {
        $this->user = User::find($this->userId);
        if (empty($this->user)) {
            // User deleted their account already.
            return;
        }

        // Cleanup the user
        $this->user->patreon_pledge = '';
        $this->user->save();

        // Cleanup the campaign boosts
        foreach ($this->user->boosts as $boost) {
            $boost->delete();
        }

        // Cleanup the patreon role
        /** @var Role $role */
        $role = Role::where('name', 'patreon')->first();
        $this->user->roles()->detach($role->id);

        // Notify the user in app about the change
        $this->user->notify(
            new Header(
                'subscription.' . ($this->cancelled ? 'failed' : 'ended'),
                'fas fa-credit-card',
                'orange'
            )
        );

        // Lastly, cleanup any discord stuff
        /** @var DiscordService $discord */
        $discord = app()->make('App\Services\DiscordService');
        $discord->user($this->user)->removeRoles();

    }
}
