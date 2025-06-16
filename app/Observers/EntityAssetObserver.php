<?php

namespace App\Observers;

use App\Facades\Images;
use App\Models\EntityAsset;

class EntityAssetObserver
{
    public function saved(EntityAsset $entityAsset): void
    {
        // When adding or changing an asset to an entity, we want to update the
        // last updated date to reflect changes in the dashboard.
        if ($entityAsset->entity) {
            $entityAsset->entity->touchQuietly();
        }
    }

    public function deleting(EntityAsset $entityAsset): void
    {
        if ($entityAsset->isFile() && ! $entityAsset->image) {
            Images::model($entityAsset)->field('imagePath')->cleanup();
        }
    }

    public function deleted(EntityAsset $entityAsset): void
    {
        if ($entityAsset->entity) {
            $entityAsset->entity->touchQuietly();
        }
    }
}
