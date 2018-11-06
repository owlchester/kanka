<?php

namespace App\Observers;

use App\Models\MiscModel;
use App\Models\Organisation;

class OrganisationObserver extends MiscObserver
{
    /**
     * @param MiscModel $model
     */
    public function saving(MiscModel $model)
    {
        parent::saving($model);

        // Removed tag id
        if (request()->getRealMethod() == 'POST' && !request()->has('organisation_id')) {
            $model->organisation_id = null;
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
     * @param Organisation $organisation
     */
    private function rebuildTree(Organisation $organisation)
    {
        if (!defined('MISCELLANY_REBUILDING_TREE')) {
            define('MISCELLANY_REBUILDING_TREE', true);
            $organisation->makeRoot()->save();
        }
    }

    /**
     * @param Organisation $organisation
     */
    public function deleting(MiscModel $organisation)
    {
        parent::deleting($organisation);

        // Update sub orgs to clean them  up
        foreach ($organisation->organisations as $child) {
            $child->organisation_id = null;
            $child->save();
        }

        // Refresh the model to make sure we have new foreign keys?
        $organisation->refresh();
    }
}
