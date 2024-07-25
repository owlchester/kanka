<?php

namespace App\Observers;

class NestedObserver
{
    public function deleting($model)
    {
        foreach ($model->children as $sub) {
            $sub->{$sub->getParentKeyName()} = null;
            $sub->saveQuietly();
        }
    }
}
