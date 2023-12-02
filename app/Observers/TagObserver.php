<?php

namespace App\Observers;

use App\Models\Tag;

class TagObserver extends MiscObserver
{
    /**
     */
    public function deleting(Tag $model)
    {
        // Update sub tags to clean them up
        foreach ($model->tags as $child) {
            $child->tag_id = null;
            $child->saveQuietly();
        }
    }
}
