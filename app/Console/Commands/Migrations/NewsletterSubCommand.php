<?php

namespace App\Console\Commands\Migrations;

use App\Services\NewsletterService;
use App\User;
use Illuminate\Console\Command;

class NewsletterSubCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:newsletter-sub';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update users who are subbed and want the newsletter to be in the correct mailerlite group';

    protected NewsletterService $service;

    protected int $count = 0;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->service = app()->make(NewsletterService::class);
        User::whereNotNull('pledge')
            ->where('settings', 'like', '%mail_release%')
            ->chunk(500, function ($users) {
                foreach ($users as $user) {
                    if (!$user->mail_release) {
                        continue;
                    }
                    $options = [
                        'releases' => (bool) $user->mail_release
                    ];
                    $this->service->user($user)->update($options);
                    $this->count++;
                }
            });

        $this->info('Processed ' . $this->count . ' users.');
    }
}
