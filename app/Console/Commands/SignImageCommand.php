<?php

namespace App\Console\Commands;

use App\Facades\Img;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SignImageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'img:sign {img} {base=users} {size=200}';

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
        $width = $height = $this->argument('size');
        if (Str::contains($width, 'x')) {
            $width = Str::before($width, 'x');
            $height = Str::after($width, 'x');
        }

        $url = Img::base($base)->url($img);

        $this->info("Url: " . $url);
    }
}
