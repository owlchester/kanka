<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Laravel\Cashier\Subscription;

class SubscriptionUpcomingAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:upcoming';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Alerts users of an upcoming yearly subscription';

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
        $subscriptions = Subscription::where();
        return 0;
    }
}
