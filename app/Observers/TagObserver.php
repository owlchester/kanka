<?php

namespace App\Observers;

use App\Models\MiscModel;
use App\Models\Tag;

class TagObserver extends MiscObserver
{
    /**
     * @param MiscModel $model
     */
    public function saving(MiscModel $model)
    {
        parent::saving($model);

        // Removed tag id
        if (request()->getRealMethod() == 'POST' && !request()->has('tag_id')) {
            $model->tag_id = null;
            $model->rebuildTree = true;
        }
    }

    /**
     * After saving the tag, let's check if the parent tag_id was removed.
     * If so, we need to make this tag a "root" to clear up the previous
     * tree. We also need to stop this from looping ad infinitum.
     * @param MiscModel $model
     */
    public function saved(MiscModel $model)
    {
        parent::saved($model);

        // After the modal has been saved, we might want to rebuild the tree.
        // Sadly, ->isDirty doesn't work here, as the model is refreshed at the end of the saving event.
        if ($model->rebuildTree) {
            $this->rebuildTree($model);
        }
    }

    /**
     * @param Tag $tag
     */
    private function rebuildTree(Tag $tag)
    {
        if (!defined('MISCELLANY_REBUILDING_TREE')) {
            define('MISCELLANY_REBUILDING_TREE', true);
            $tag->makeRoot()->save();
        }
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
     * @param Tag $section
     */
    public function deleting(MiscModel $section)
    {
        parent::deleting($section);

        /**
         * We need to keep this, because the tree plugin wants to delete child when deleting the parent. It's stupid.
         */
        // Set all children to no longer have this section
        foreach ($section->allChildren() as $child) {
            $child->child->tag_id = null;
            $child->child->save();
        }

        // Update sub sections to clean them  up
        foreach ($section->tags as $child) {
            $child->tag_id = null;
            $child->save();
        }

        // Refresh the model to make sure we have new foreign keys?
        $section->refresh();
    }
}
