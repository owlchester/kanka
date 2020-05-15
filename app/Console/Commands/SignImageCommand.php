<?php

namespace App\Console\Commands;

use App\Facades\Img;
use Illuminate\Console\Command;

class SignImageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'img:sign {img} {base=users}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sign an image for thumbor';

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
        $img = $this->argument('img');
        $base = $this->argument('base');
        $url = Img::crop(200, 200)->url($img, $base);

        $this->info("Url: " . $url);
    }
}
