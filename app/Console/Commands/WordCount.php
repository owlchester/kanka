<?php

namespace App\Console\Commands;

use App\Models\CharacterTrait;
use App\Models\Entity;
use App\Models\MapLayer;
use App\Models\MapMarker;
use App\Models\Post;
use App\Models\QuestElement;
use App\Models\TimelineElement;
use App\Models\TimelineEra;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class WordCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:word-count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Count the words in every entity';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $start = Carbon::now();
        $this->info('Started at ' . date('H:i:s'));

        $this->process(Entity::class);
        $this->process(Post::class);
        $this->process(TimelineElement::class);
        $this->process(TimelineEra::class);
        $this->process(QuestElement::class, 'description');
        $this->process(MapMarker::class);
        $this->process(MapLayer::class);
        $this->process(CharacterTrait::class);
        $this->info('Ended at ' . date('H:i:s') . ' after ' . round($start->diffInMinutes(), 3) . ' min');
    }

    protected function process(string $className, string $field = 'entry')
    {
        $model = app()->make($className);

        //DB::statement('UPDATE ' . $model->getTable() . ' SET words = null');
        $this->info($className);
        $total = $model::whereNull('words')->whereNotNull($field)->count();
        $progressBar = $this->output->createProgressBar($total);
        $model::whereNotNull($field)->whereNull('words')
            ->chunkById(5000, function ($models) use ($progressBar) {
                /** @var Entity $model */
                foreach ($models as $model) {
                    $model->words = str_word_count(strip_tags($model->{$model->entryFieldName()}));
                    $model->saveQuietly();
                    $progressBar->advance();
                }
            });
        $progressBar->finish();
        $this->newLine();
    }
}
