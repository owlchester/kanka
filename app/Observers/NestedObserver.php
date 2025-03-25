<?php

namespace App\Observers;

class NestedObserver
{
    public function saving($model)
    {
        if (! $model->parent) {
            return;
        }
        // If we have a parent, we make the current model isn't a parent of itself
        $bloodline = $model->parent->ancestors()->pluck('id')->toArray();
        if (in_array($model->id, $bloodline)) {
            $model->{$model->getParentKeyName()} = null;
        }
    }

    public function deleting($model)
    {
        foreach ($model->children as $sub) {
            $sub->{$sub->getParentKeyName()} = null;
            $sub->saveQuietly();
        }
    }
}
