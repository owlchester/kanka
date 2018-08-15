<?php

namespace App\Observers;

use App\Models\MiscModel;
use App\Models\Section;

class SectionObserver extends MiscObserver
{
    /**
     * @param MiscModel $model
     */
    public function saving(MiscModel $model)
    {
        parent::saving($model);
    }

//    public function saved(MiscModel $model)
//    {
//        // Need to update the parent tree
//        $newParentId = $model->section_id;
//        $originalParentId = $model->getOriginal('section_id');
//        echo "Comparing original $originalParentId to the current " . $model->section_id . '<br>';
//
//        if (!empty($originalParentId) && $originalParentId != $model->section_id) {
//
//            $model->section_id = $originalParentId;
//            ++$model::$actionsPerformed;
//            $model->refreshNode();
//            dd($model->parent->name);
//            $model->section_id = $newParentId;
//        }
//    }

    /**
     * @param Section $section
     */
    public function deleting(MiscModel $section)
    {
        parent::deleting($section);

        /**
         * We need to keep this, because the tree plugin wants to delete child when deleting the parent. It's stupid.
         */
        // Set all children to no longer have this section
        foreach ($section->allChildren() as $child) {
            $child->child->section_id = null;
            $child->child->save();
        }

        // Update sub sections to clean them  up
        foreach ($section->sections as $child) {
            $child->section_id = null;
            $child->save();
        }

        // Refresh the model to make sure we have new foreign keys?
        $section->refresh();
    }
}
