<?php

namespace App\Console\Commands;

use App\Models\EntityEvent;
use App\Models\EntityEventType;
use App\Models\Journal;
use App\Models\Quest;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class MigrateEntityEventType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:calendar_date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate calendar dates to the new system';

    protected $count = 0;

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
     * @return int
     */
    public function handle()
    {
        $fields = ['id', 'name', 'calendar_id', 'calendar_year', 'calendar_month', 'calendar_day'];
        Quest::select($fields)->with(['entity'])->whereNotNull('calendar_id')->chunk(500, function ($quests): void {
            foreach ($quests as $quest) {
                $this->parse($quest);
            }
        });
        $this->info('Migrated ' . $this->count . ' quests.');

        $this->count = 0;
        Journal::select($fields)->with(['entity'])->whereNotNull('calendar_id')->chunk(500, function ($journals): void {
            foreach ($journals as $journal) {
                $this->parse($journal);
            }
        });
        $this->info('Migrated ' . $this->count . ' journals.');
        return 0;
    }

    /**
     * @param Journal|Quest $model
     * @return void
     */
    protected function parse(Journal|Quest $model): void
    {
        // No entity? Eh
        if (empty($model->entity)) {
            $this->error('Invalid entity for ' . get_class($model) . ' #' . $model->id);
            return;
        }

        // Since the trait overrides the $model->calendar_id attribute, we need this workaround
        $attributes = $model->getAttributes();

        // Find the reminder that fits the entity
        /** @var EntityEvent|null $reminder */
        $reminder = EntityEvent::select('id')->where([
            'entity_id' => $model->entity->id,
            'calendar_id' => Arr::get($attributes, 'calendar_id'),
            'year' => Arr::get($attributes, 'calendar_year'),
            'month' => Arr::get($attributes, 'calendar_month'),
            'day' => Arr::get($attributes, 'calendar_day'),
        ])->first() ?? null;

        if (empty($reminder)) {
            $this->error('Invalid reminder for ' . get_class($model) . ' #' . $model->id);
            return;
        }

        $reminder->type_id = EntityEventType::CALENDAR_DATE;
        $reminder->save();

        $this->count++;
    }
}
