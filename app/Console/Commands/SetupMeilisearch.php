<?php

namespace App\Console\Commands;

use App\Models\Ability;
use App\Models\Attribute;
use App\Models\Calendar;
use App\Models\Character;
use App\Models\Creature;
use App\Models\Event;
use App\Models\Family;
use App\Models\Item;
use App\Models\Journal;
use App\Models\Location;
use App\Models\Map;
use App\Models\Note;
use App\Models\Organisation;
use App\Models\Post;
use App\Models\Quest;
use App\Models\QuestElement;
use App\Models\Race;
use App\Models\Tag;
use App\Models\Timeline;
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
            Ability::class,
            Calendar::class,
            Character::class,
            Creature::class,
            Event::class,
            Family::class,
            Item::class,
            Journal::class,
            Location::class,
            Map::class,
            Note::class,
            Organisation::class,
            Quest::class,
            Race::class,
            Timeline::class,
            Tag::class,
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
        $this->info('Ended at ' . date('H:i:s') . ' after ' . $start->diffInMinutes() . ' min');
    }
}
