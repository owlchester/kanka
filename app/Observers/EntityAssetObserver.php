<?php

namespace App\Observers;

use App\Models\EntityAsset;
use App\Facades\Images;

/**
 *
 */
class EntityAssetObserver
{
    public function saved(EntityAsset $entityAsset): void
    {
        // When adding or changing an asset to an entity, we want to update the
        // last updated date to reflect changes in the dashboard.
        $entityAsset->entity->child->touchQuietly();
    }

    public function deleting(EntityAsset $entityAsset): void
    {
        if ($entityAsset->isFile() && !$entityAsset->image) {
            Images::cleanup($entityAsset, 'imagePath');
        }
    }

    public function deleted(EntityAsset $entityAsset): void
    {
        $entityAsset->entity->child->touch();
    }
}
