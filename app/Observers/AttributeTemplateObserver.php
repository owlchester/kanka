<?php

namespace App\Observers;

use App\Models\AttributeTemplate;
use App\Models\MiscModel;

class AttributeTemplateObserver extends MiscObserver
{
    /**
     * @param AttributeTemplate $attributeTemplate
     */
    public function deleting(MiscModel $attributeTemplate)
    {
        /**
         * We need to do this ourselves and not let mysql to it (set null), because the plugin wants to delete
         * all descendants when deleting the parent, which is stupid.
         */
        foreach ($attributeTemplate->attributeTemplates as $sub) {
            $sub->attribute_template_id = null;
            $sub->save();
        }

        // We need to refresh our foreign relations to avoid deleting our children nodes again
        $attributeTemplate->refresh();
    }
}
