<?php

namespace App\Console\Commands;

use App\Models\Quest;
use Illuminate\Console\Command;

class MigrateQuestGiver extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quests:instigator';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate quest instigators';

    protected int $count = 0;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Quest::whereNotNull('character_id')
            ->whereNull('instigator_id')
            ->with(['character', 'character.entity'])
            ->has('character')
            ->has('character.entity')
            ->chunk(2000, function ($quests) {
                foreach ($quests as $quest) {
                    $this->migrate($quest);
                }
            });

        $this->info('Migrated ' . $this->count . ' quest instigators');
    }

    protected function migrate(Quest $quest): void
    {
        // @phpstan-ignore-next-line
        $quest->instigator_id = $quest->character->entity->id;
        $quest->saveQuietly();
        $this->count++;
    }
}
