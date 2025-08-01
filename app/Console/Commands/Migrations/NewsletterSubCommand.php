<?php

namespace App\Console\Commands\Migrations;

use App\Models\User;
use App\Services\NewsletterService;
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

    protected int $count = 0;

    public function __construct(protected NewsletterService $service)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        User::whereNotNull('pledge')
            ->where('pledge', '<>', '')
            ->where('settings', 'like', '%mail_release%')
            ->chunk(100, function ($users) {
                foreach ($users as $user) {
                    if (! $user->mail_release) {
                        continue;
                    }
                    $options = [
                        'releases' => (bool) $user->mail_release,
                    ];
                    if ($this->service->user($user)->update($options)) {
                        $this->count++;

                        continue;
                    }
                    $this->error($this->service->error()->getMessage());
                }
                sleep(60);
            });

        $this->info('Processed ' . $this->count . ' users.');
    }
}
