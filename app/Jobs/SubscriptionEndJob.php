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
    public $user;

    /** @var bool */
    public $cancelled;

    /** @var string the user's reason for cancelling */
    public $reason;

    public function __construct(User $user, string $reason = '', bool $cancelled = false)
    {
        $this->user = $user;
        $this->cancelled = $cancelled;
        $this->reason = $reason;
    }

    /**
     * A user has ended their subscription, either by cancelling or automatically by the script.
     * Let's send them a notification, update their discord roles, send an email, and update their user status
     */
    public function handle()
    {
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

        // Send an email to the admins
        Mail::to('no-reply@kanka.io')
            ->send(
                new CancelledSubscriptionMail($this->user, $this->reason)
            );

        // Lastly, cleanup any discord stuff
        /** @var DiscordService $discord */
        $discord = app()->make('App\Services\DiscordService');
        $discord->user($this->user)->removeRoles();

    }
}
