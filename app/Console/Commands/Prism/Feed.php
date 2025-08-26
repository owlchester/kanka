<?php

namespace App\Console\Commands\Prism;

use App\Jobs\BragiFeedJob;
use Illuminate\Console\Command;

class Feed extends Command
{
    protected $signature = 'prism:feed {id : Campaign ID}';
    protected $description = 'Vectorize data for later searching';

    public function handle()
    {
        $campaignId = $this->argument('id');
        $this->dispatch($campaignId);
        return 0;
    }

    /**
     * @return \Illuminate\Foundation\Bus\PendingDispatch
     */
    protected function dispatch(int $mapID)
    {
        return BragiFeedJob::dispatch($mapID);
    }
}




