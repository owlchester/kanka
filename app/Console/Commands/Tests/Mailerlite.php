<?php

namespace App\Console\Commands\Tests;

use App\Models\User;
use App\Services\NewsletterService;
use Illuminate\Console\Command;

class Mailerlite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:mailerlite';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the mailerlite integration';

    public function __construct(protected NewsletterService $service)
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
        $user = User::findorFail(13);

        if ($this->service->user($user)->isSubscribed()) {
            $this->service->remove();
        } else {
            $options = [
                'releases' => (bool) $user->mail_release,
            ];

            $this->service->update($options);
        }

        return Command::SUCCESS;
    }
}
