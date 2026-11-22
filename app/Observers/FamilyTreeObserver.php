<?php

namespace App\Observers;

use App\Facades\EntityLogger;
use App\Models\Entity;
use App\Models\FamilyTree;
use App\Services\Families\FamilyTreeMigrator;
use Illuminate\Support\Facades\DB;

class FamilyTreeObserver
{
    public function saved(FamilyTree $familyTree): void
    {
        if ($familyTree->family?->entity && auth()->check()) {
            EntityLogger::entity($familyTree->family->entity)->updatedFamilyTree();
        }

        $this->syncEntities($familyTree);
    }

    public function syncEntities(FamilyTree $familyTree): void
    {
        $entityIds = FamilyTreeMigrator::extractEntityIds($familyTree->config);

        if (empty($entityIds)) {
            DB::table('family_tree_entities')
                ->where('family_tree_id', $familyTree->id)
                ->delete();

            return;
        }

        $validEntityIds = Entity::query()
            ->whereIn('id', $entityIds)
            ->pluck('id')
            ->map(fn ($id): int => (int) $id)
            ->all();

        if (empty($validEntityIds)) {
            DB::table('family_tree_entities')
                ->where('family_tree_id', $familyTree->id)
                ->delete();

            return;
        }

        DB::table('family_tree_entities')
            ->where('family_tree_id', $familyTree->id)
            ->whereNotIn('entity_id', $validEntityIds)
            ->delete();

        $existing = DB::table('family_tree_entities')
            ->where('family_tree_id', $familyTree->id)
            ->pluck('entity_id')
            ->map(fn ($id): int => (int) $id)
            ->all();

        $toInsert = array_diff($validEntityIds, $existing);
        if (! empty($toInsert)) {
            $rows = array_map(fn (int $entityId): array => [
                'family_tree_id' => $familyTree->id,
                'entity_id' => $entityId,
            ], $toInsert);

            DB::table('family_tree_entities')->insertOrIgnore($rows);
        }
    }
}
