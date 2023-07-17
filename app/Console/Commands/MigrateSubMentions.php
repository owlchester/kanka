<?php

namespace App\Console\Commands;

use App\Models\EntityMention;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MigrateSubMentions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mentions:migrate-sub';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update mentions linked to quest elements, timelines and posts to be sortable by name';

    protected int $count = 0;

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $start = Carbon::now();
        $this->warn('Start at ' . $start);

        EntityMention::with([
            'questElement' => function ($sub) {
                $sub->select('id', 'name', 'quest_id');
            },
            'questElement.quest' => function ($sub) {
                $sub->select('id', 'name', 'is_private');
            },
            'questElement.quest.entity' => function ($sub) {
                $sub->select('id', 'entity_id', 'type_id');
            }])
            ->whereNotNull('quest_element_id')
            ->whereNull('entity_id')
            ->has('questElement')
            ->has('questElement.quest')
            ->has('questElement.quest.entity')
            ->chunkById(500, function ($mentions) {
                foreach ($mentions as $mention) {
                    $mention->entity_id = $mention->questElement->quest->entity->id;
                    $mention->saveQuietly();
                    $this->count++;
                }
            });
        $this->info('Migrated ' . $this->count . ' quest element mentions.');

        $this->count = 0;
        EntityMention::with([
            'timelineElement' => function ($sub) {
                $sub->select('id', 'name', 'timeline_id');
            },
            'timelineElement.timeline' => function ($sub) {
                $sub->select('id', 'name', 'is_private');
            },
            'timelineElement.timeline.entity' => function ($sub) {
                $sub->select('id', 'entity_id', 'type_id');
            }])
            ->whereNotNull('timeline_element_id')
            ->whereNull('entity_id')
            ->has('timelineElement')
            ->has('timelineElement.timeline')
            ->has('timelineElement.timeline.entity')
            ->chunkById(500, function ($mentions) {
                foreach ($mentions as $mention) {
                    $mention->entity_id = $mention->timelineElement->timeline->entity->id;
                    $mention->saveQuietly();
                    $this->count++;
                }
            });
        $this->info('Migrated ' . $this->count . ' timeline element mentions.');

        $this->count = 0;
        EntityMention::with([
            'post' => function ($sub) {
                $sub->select('id', 'entity_id');
            }])
            ->whereNotNull('entity_note_id')
            ->whereNull('entity_id')
            ->has('post')
            ->has('post.entity')
            ->chunkById(5000, function ($mentions) {
                foreach ($mentions as $mention) {
                    $mention->entity_id = $mention->post->entity_id;
                    $mention->saveQuietly();
                    $this->count++;
                }
            });
        $this->info('Migrated ' . $this->count . ' post mentions.');

        $now = Carbon::now();
        $this->warn('End in ' . $now->diffInSeconds($start) . ' seconds at ' . $now);
    }
}
