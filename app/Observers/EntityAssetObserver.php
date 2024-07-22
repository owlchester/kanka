<?php

namespace App\Observers;

use App\Models\EntityAsset;
use App\Facades\Images;

class EntityAssetObserver
{
    use PurifiableTrait;

    /**
     * @return void
     */
    public function saving(EntityAsset $entityAsset)
    {
        $entityAsset->name = $this->purify($entityAsset->name);
    }

    /**
     * @return void
     */
    public function saved(EntityAsset $entityAsset)
    {
        // When adding or changing an asset to an entity, we want to update the
        // last updated date to reflect changes in the dashboard.
        $entityAsset->entity->child->touchQuietly();
    }

    /**
     * @return void
     */
    public function deleting(EntityAsset $entityAsset)
    {
        if ($entityAsset->isFile()) {
            Images::cleanup($entityAsset, 'imagePath');
        }
    }

    /**
     * @return void
     */
    public function deleted(EntityAsset $entityAsset)
    {
        if ($entityAsset->entity) {
            $entityAsset->entity->child->touch();
        }
    }
}
