<?php

namespace App\Observers;

use App\Models\MiscModel;
use App\Models\Tag;

class TagObserver extends MiscObserver
{
    /**
     * @param Tag $model
     */
    public function deleting(MiscModel $model)
    {
        // Update sub tags to clean them up
        foreach ($model->tags as $child) {
            $child->tag_id = null;
            $child->save();
        }

        $this->cleanupTree($model, 'tag_id');
    }
}
