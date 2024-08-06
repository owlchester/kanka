<?php

namespace App\Observers;

use App\Models\Bookmark;

class BookmarkObserver
{
    /**
     */
    public function saving(Bookmark $model)
    {
        // Handle empty or wrong positions
        if (empty($model->position)) {
            $model->position = Bookmark::max('position') + 1;
        } else {
            $model->position = (int) $model->position;
        }

        // Handle the entity type or direct entity
        if (!empty($model->type)) {
            $model->entity_id = null;
            //$model->tab = null;
            $model->menu = '';
        } else {
            $model->type = null;
            $model->filters = null;
        }

        // Only allow certain keys in the options array
        $options = $model->options;
        if (!empty($options)) {
            $model->options = array_intersect_key($model->options, array_flip($model->optionsAllowedKeys));
        }

        // Is private hook for non-admin (who can't set is_private)
        if (!isset($model->is_private)) {
            $model->is_private = false;
        }
    }
}
