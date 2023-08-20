<?php

namespace App\Traits;

use App\Models\Location;
use App\Models\MiscModel;

trait CanFixTree
{
    /**
     * When transforming or moving an entity, we need to fix its tree
     * @param MiscModel $model
     * @return void
     */
    protected function fixTree(MiscModel $model): void
    {
        /** @var Location $model */
        // When transforming to a nested model, we need to recalculate the tree bounds to
        // place it correctly in the overall campaign tree.
        if (!method_exists($model, 'recalculateTreeBounds')) {
            // If it's not nested with a full tree, but still has a parent id, set that to null
            if (method_exists($model, 'getParentIdName')) {
                $model->{$model->getParentIdName()} = null;
            }
            return;
        }
        $isLocationWithParent = in_array('parent_location_id', $model->getFillable()) && !empty($model->getParentId());
        // If it's not a location or the parent location is empty, force the parent to be properly empty
        if (!$isLocationWithParent) {
            /** @var Location $model */
            $model->setParentId(null);
        }
        $model->{$model->getRgtName()} = 0;
        $model->{$model->getLftName()} = 0;
        if ($model->exists) {
            $model->exists = false;
            $model->recalculateTreeBounds();
            $model->exists = true;
        } else {
            $model->recalculateTreeBounds();
        }
        // For a location with a parent, place it inside the tree
        if ($isLocationWithParent) {
            $model->forcePendingAction();
        }
    }
}
