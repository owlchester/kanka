<?php

namespace App\Console\Commands;

use App\Models\EntityEvent;
use App\Models\EntityEventType;
use App\Models\Journal;
use App\Models\Quest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateCalendarDates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate calendar date events to have the proper type_id';

    protected int $count = 0;
    protected int $cleared = 0;

    protected array $reminders = [];
    protected array $clears = [];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Journal::select('journals.*')
            ->joinEntity()
            ->leftJoin('entity_events as r', function ($sub) {
                return $sub
                    ->on('r.entity_id', 'e.id')
                    ->where('r.type_id', EntityEventType::CALENDAR_DATE);
            })
            ->whereNotNull('journals.calendar_id')
            ->whereNull('r.id')
            ->with('entity')
            ->with('entity.events')
            ->chunk(1000, function ($journals) {
                $this->clears = [];
                $this->reminders = [];
                foreach ($journals as $journal) {
                    $this->fix($journal);
                }

                if (!empty($this->clears)) {
                    $this->cleared += count($this->clears);
                    DB::statement('UPDATE journals SET calendar_id = null, calendar_day = null, calendar_month = null, calendar_year = null WHERE id IN (' . implode(', ', $this->clears) . ')');
                }
                if (!empty($this->reminders)) {
                    $this->count += count($this->reminders);
                    DB::statement('UPDATE entity_events SET type_id = ' . EntityEventType::CALENDAR_DATE . ' WHERE id IN (' . implode(', ', $this->reminders) . ')');
                }
            });

        $this->info('Migrated ' . $this->count . ' and cleared ' . $this->cleared . ' journals.');

        Quest::select('quests.*')
            ->joinEntity()
            ->leftJoin('entity_events as r', function ($sub) {
                return $sub
                    ->on('r.entity_id', 'e.id')
                    ->where('r.type_id', EntityEventType::CALENDAR_DATE);
            })
            ->whereNotNull('quests.calendar_id')
            ->whereNull('r.id')
            ->with('entity')
            ->with('entity.events')
            ->chunk(1000, function ($quests) {
                $this->clears = [];
                $this->reminders = [];
                foreach ($quests as $quest) {
                    $this->fix($quest);
                }

                if (!empty($this->clears)) {
                    $this->cleared += count($this->clears);
                    DB::statement('UPDATE quests SET calendar_id = null, calendar_day = null, calendar_month = null, calendar_year = null WHERE id IN (' . implode(', ', $this->clears) . ')');
                }
                if (!empty($this->reminders)) {
                    $this->count += count($this->reminders);
                    DB::statement('UPDATE entity_events SET type_id = ' . EntityEventType::CALENDAR_DATE . ' WHERE id IN (' . implode(', ', $this->reminders) . ')');
                }
            });

        $this->info('Migrated ' . $this->count . ' and cleared ' . $this->cleared . ' quests.');
    }

    protected function fix(Journal|Quest $model)
    {
        // Old code, try and get the first reminder
        /** @var EntityEvent $reminder */
        $reminder = $model->entity->calendarDateEvents->first();
        if (!$reminder && $reminder !== null) {
            // No reminder? Might be an entity copied over from one campaign to another, in which case we can reset it
            $this->clears[] = $model->id;
            return;
        }
        $this->reminders[] = $reminder->id;
    }
}
