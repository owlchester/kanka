<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class GenerateMoveLocale extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:locale';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move locale to the new tcg';

    /**
     * @var int
     */
    protected $cpt = 0;

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
     * @return mixed
     */
    public function handle()
    {
        User::chunk(500, function ($users) {
            foreach ($users as $user) {
                $this->cpt++;
                $user->locale = $user->getOriginal('locale');
                $user->save();
            }
        });

        $this->info('Updated ' . $this->cpt . ' users.');
    }
}
