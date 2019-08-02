<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityEvent;
use App\Models\EntityMention;
use App\Models\EntityNote;
use App\Models\MiscModel;
use App\Services\EntityMappingService;
use App\Services\EntityService;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class GenerateEntityEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'entity:event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the entity event dates.';

    protected $updatedEvents = 0;

        /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        EntityEvent::chunk(5000, function ($reminders) {
            /** @var EntityEvent $reminder */
            foreach ($reminders as $reminder) {
                $dates = explode('-', $reminder->date);
                $start = count($dates) == 4 ? 1 : 0;
                $reminder->year = ($start == 1 ? '-' : null) . Arr::get($dates, $start, 1);
                $reminder->month = Arr::get($dates, ++$start, 2);
                $reminder->day = Arr::get($dates, ++$start, 2);

                $reminder->save();
                $this->updatedEvents++;
            }
        });

        $this->info("Updated {$this->updatedEvents} entity events.");

        return true;
    }
}
