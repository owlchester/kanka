<?php

namespace App\Console\Commands\Migrations;

use App\Models\Bookmark;
use App\Models\EntityType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BookmarkEntityType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:bookmarks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate bookmarks to the new entity type id foreign key';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Migrating bookmarks to the new entity_type_id property');
        $entityTypes = EntityType::default()->get();
        foreach ($entityTypes as $entityType) {
            $statement = 'UPDATE bookmarks SET entity_type_id = ' . $entityType->id . ' WHERE type = \'' . $entityType->code . '\'';
            DB::statement($statement);
        }
        $this->info('Finished');
    }
}
