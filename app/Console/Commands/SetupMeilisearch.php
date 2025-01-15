<?php

namespace App\Console\Commands;

use App\Models\Attribute;
use App\Models\Entity;
use App\Models\Post;
use App\Models\QuestElement;
use App\Models\TimelineElement;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Meilisearch\Client;

class SetupMeilisearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:meilisearch
        {--c|chunk= : The number of records to import at a time (Defaults to configuration value: `scout.chunk.searchable`)}
    ';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup meilisearch';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (config('app.lazy')) {
            $this->error('Config error:');
            $this->error('Temporarily remove APP_LAZY=true from your .env file.');
            return;
        }

        //Update Non Separator Tokens for entity mentions
        $start = Carbon::now();
        $this->info('Meilisearch import started at ' . date('H:i:s'));
        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));
        $client->getKeys();
        $client->deleteIndex('entities');
        $client->index('entities')->resetSeparatorTokens();
        $client->index('entities')->updateNonSeparatorTokens([':']);
        $client->index('entities')->updateFilterableAttributes(['campaign_id']);


        $models = [
            Attribute::class,
            Entity::class,
            Post::class,
            QuestElement::class,
            TimelineElement::class,
        ];
        foreach ($models as $model) {
            $time = Carbon::now();
            $object = new $model();
            $this->info('Importing ' . number_format($object->count()) . ' [' . $model . '] at ' . date('H:i:s'));
            $object::makeAllSearchable($this->option('chunk'));
            $this->info('- Done in ' . round($time->diffInMinutes(), 4) . ' min');
            Log::info('Meilisearch', ['model' => $model]);
        }
        $this->info('Ended at ' . date('H:i:s') . ' after ' . round($start->diffInMinutes(), 3) . ' min');


        if (config('scout.queue')) {
            $this->newLine();
            $this->warn('Meilisearch seeding has been queued.');
            $this->warn('Now run `sail artisan queue:work` to finish importing.');
        }
    }
}
