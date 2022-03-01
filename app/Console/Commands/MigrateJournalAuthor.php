<?php

namespace App\Console\Commands;

use App\Models\Journal;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateJournalAuthor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'journals:author';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate journal authors to new structure';

    protected $count = 0;
    protected $chunk = 1000;


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

        \App\Models\Journal::whereNotNull('character_id')
            ->whereNull('author_id')
            ->with(['character', 'character.entity'])
            ->has('character')
            ->chunkById($this->chunk, function ($rows) {
            $this->info('Looping ' . $this->chunk . '...');
            foreach ($rows as $journal) {
                /** @var Journal $journal */
                $journal->author_id = $journal->character->entity->id;
                $journal->timestamps = false;
                $journal->update(['author_id']);
                $this->count++;
            }
        });

        $this->info('Migrated ' . $this->count . ' journals.');
        return 0;
    }
}
