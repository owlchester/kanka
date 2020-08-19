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
            $full = $width;
            $width = Str::before($full, 'x');
            $height = Str::after($full, 'x');
        }

        if (!empty($height) && $height != "200") {

            $url = Img::console()->base($base)->crop($width, $height)->url($img);
        } else {
            $url = Img::console()->base($base)->url($img);
        }

        $this->info("Url: " . $url);
    }
}

