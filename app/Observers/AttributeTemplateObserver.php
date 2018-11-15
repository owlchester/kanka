<?php

namespace App\Observers;

use App\Models\AttributeTemplate;
use App\Models\MiscModel;

class AttributeTemplateObserver extends MiscObserver
{
    /**
     * @param MiscModel $model
     */
    public function saving(MiscModel $model)
    {
        parent::saving($model);

        // Removed tag id
        if (request()->getRealMethod() == 'POST' && !request()->has('attribute_template_id')) {
            $model->attribute_template_id = null;
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
     * @param AttributeTemplate $attributeTemplate
     */
    private function rebuildTree(AttributeTemplate $attributeTemplate)
    {
        if (!defined('MISCELLANY_REBUILDING_TREE')) {
            define('MISCELLANY_REBUILDING_TREE', true);
            $attributeTemplate->makeRoot()->save();
        }
    }
}
