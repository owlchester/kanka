<?php

namespace App\Console\Commands;

use App\Models\FamilyTree;
use App\Observers\FamilyTreeObserver;
use Illuminate\Console\Command;

class SyncFamilyTreeEntitiesCommand extends Command
{
    protected $signature = 'kanka:family-trees:sync-entities';

    protected $description = 'Sync family_tree_entities index table for all existing family trees';

    public function handle(FamilyTreeObserver $observer): int
    {
        $count = 0;

        FamilyTree::query()->chunkById(200, function ($trees) use ($observer, &$count): void {
            foreach ($trees as $tree) {
                $observer->syncEntities($tree);
                $count++;
            }
        });

        $this->info("Synced {$count} family trees.");

        return self::SUCCESS;
    }
}
