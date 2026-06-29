<?php

namespace App\Console\Commands;

use App\Models\Attribute;
use App\Models\Entity;
use App\Models\Post;
use App\Models\QuestElement;
use App\Models\TimelineElement;
use Illuminate\Console\Command;

class TruncateMeilisearchEntries extends Command
{
    protected $signature = 'meilisearch:truncate-entries';

    protected $description = 'Re-index records with oversized entries so Meilisearch stores the truncated version.';

    public function handle(): void
    {
        $models = [
            'entities' => [Entity::class, 'entry', 50000],
            'posts' => [Post::class, 'entry', 50000],
            'quest elements' => [QuestElement::class, 'entry', 50000],
            'timeline elements' => [TimelineElement::class, 'entry', 50000],
            'attributes' => [Attribute::class, 'value', 1000],
        ];

        foreach ($models as $label => [$model, $column, $limit]) {
            $count = $model::whereRaw("CHAR_LENGTH({$column}) > {$limit}")->count();

            if ($count === 0) {
                $this->line("No oversized {$label}.");

                continue;
            }

            $this->info("Re-indexing {$count} {$label}...");

            $model::whereRaw("CHAR_LENGTH({$column}) > {$limit}")
                ->chunkById(500, fn ($records) => $records->searchable());

            $this->info('Done.');
        }
    }
}
