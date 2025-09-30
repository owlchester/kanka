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
        $table = $model->getTable();

        // DB::statement('UPDATE ' . $model->getTable() . ' SET words = null');
        $this->info($className);
        $total = $model::whereNull('words')->whereNotNull($field)->count();
        $progressBar = $this->output->createProgressBar($total);

        $batchSize = 5000;
        $processed = 0;

        do {
            // Process in batches using LIMIT/OFFSET or better yet, use a cursor approach
            $updated = DB::table($table)
                ->whereNotNull($field)
                ->whereNull('words')
                ->limit($batchSize)
                ->update([
                    'words' => DB::raw("
                    CASE
                        WHEN TRIM(REGEXP_REPLACE($field, '<[^>]*>', '')) = '' THEN 0
                        ELSE (
                            LENGTH(TRIM(REGEXP_REPLACE($field, '<[^>]*>', ''))) -
                            LENGTH(REPLACE(TRIM(REGEXP_REPLACE($field, '<[^>]*>', '')), ' ', '')) + 1
                        )
                    END
                "),
                ]);

            $processed += $updated;
            $progressBar->advance($updated);

            // Small delay to prevent overwhelming the database
            usleep(10000); // 10ms delay

        } while ($updated > 0);

        $progressBar->finish();
        $this->newLine();

        $this->info("Processed {$processed} records total");

    }
}
