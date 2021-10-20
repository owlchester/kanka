<?php

namespace App\Console\Commands;

use App\Models\Theme;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RemoveFutureTheme extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:future-theme';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removed the future theme from the app';

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
        $count = DB::statement('UPDATE users SET theme = null where theme = \'future\'');
        $this->info('Updated ' . $count . ' users.');

        $theme = Theme::where('name', 'future')->first();
        $theme->delete();
        $this->info('Theme deleted.');
        return 0;
    }
}
