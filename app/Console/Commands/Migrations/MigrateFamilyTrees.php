<?php

namespace App\Console\Commands\Migrations;

use App\Models\FamilyTree;
use App\Services\Families\FamilyTreeGraph;
use Illuminate\Console\Command;

class MigrateFamilyTrees extends Command
{
    protected $signature = 'migrate:family-trees
        {--dry-run : Report what would be migrated without writing changes}
        {--family= : Only migrate the tree for this family id}';

    protected $description = 'Migrate nested family trees to the versioned graph format';

    public function handle(): int
    {
        $query = FamilyTree::query()->whereNotNull('config');
        if ($this->option('family')) {
            $query->where('family_id', $this->option('family'));
        }

        $migrated = 0;
        $skipped = 0;
        $failed = 0;

        $query->each(function (FamilyTree $tree) use (&$migrated, &$skipped, &$failed): void {
            $config = $tree->config;
            if (empty($config)) {
                $skipped++;

                return;
            }
            if (isset($config['version'], $config['nodes'], $config['edges'])) {
                $skipped++;

                return;
            }

            try {
                $graph = FamilyTreeGraph::normalize($config);
                FamilyTreeGraph::validate($graph);
                $migrated++;
                $this->line(($this->option('dry-run') ? 'Would migrate ' : 'Migrated ') . "family {$tree->family_id}.");

                if (! $this->option('dry-run')) {
                    $tree->config = $graph;
                    $tree->saveQuietly();
                }
            } catch (\Throwable $exception) {
                $failed++;
                $this->error("Family {$tree->family_id} failed: {$exception->getMessage()}");
            }
        });

        $this->info("Family trees migrated: {$migrated}; skipped: {$skipped}; failed: {$failed}.");

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }
}
