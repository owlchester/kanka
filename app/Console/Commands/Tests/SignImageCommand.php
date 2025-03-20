<?php

namespace App\Console\Commands\Tests;

use App\Facades\Img;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SignImageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     *
     * @example php artisan img:sign images/tiers/xxx-325.png app 200
     * @example php artisan img:sign locations/xxx.png user 200x304
     * @example php artisan img:sign images/features/kanka-feature-dashboard.jpg app
     */
    protected $signature = 'img:sign {img} {base=user} {size=200}';

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
        $width = (int) $width;
        $height = (int) $height;

        if (!empty($height)) {
            $url = Img::console()->base($base)->crop($width, $height)->url($img);
        } else {
            $url = Img::console()->base($base)->url($img);
        }

        $this->info("Base: {$base}");
        $this->info("Size: {$width} x {$height}");
        $this->info("" . $url);

        return 0;
    }
}
