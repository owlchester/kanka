<?php

namespace App\Console\Commands\Subscriptions;

use App\Jobs\Emails\Subscriptions\ExpiringCardAlert;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExpiringCardCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:expiring-card';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Alert subscribers who have an old card set up in their settings';

    /** @var int Number of alerts sent */
    protected $count = 0;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now()->endOfMonth();
        $this->info('Looking for cards expiring on ' . $now->format('Y-m-d'));

        User::where('card_expires_at', $now)
            ->with('subscriptions')
            ->chunk(100, function ($users) {
                foreach ($users as $user) {
                    $this->notify($user);
                }
            });

        $this->info('Alerted ' . $this->count . ' subscribers.');
        return 0;
    }

    /**
     * @param User $user
     */
    protected function notify(User $user): void
    {
        // Check the user has a card
        if (!$user->subscribed('kanka')) {
            // Has a card but isn't subbed, ignore
            $this->warn('Expired card but unsubbed user');
            return;
        }

        // Notify the user about their soon expiring card
        ExpiringCardAlert::dispatch($user);
        $this->count++;
    }
}
