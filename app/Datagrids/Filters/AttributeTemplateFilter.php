<?php

namespace App\Datagrids\Filters;

use App\Models\AttributeTemplate;

class AttributeTemplateFilter extends DatagridFilter
{
    /**
     * Filters available for attribute templates
     */
    public function __construct()
    {
        $this
            ->add('name')
            ->add([
                'field' => 'attribute_template_id',
                'label' => __('attribute_templates.fields.attribute_template'),
                'type' => 'select2',
                'route' => route('attribute_templates.find'),
                'placeholder' =>  __('attribute_templates.placeholders.attribute_template'),
                'model' => AttributeTemplate::class,
            ])
            ->isPrivate()
            ->template()
            ->hasAttributes()
            ->tags()
            ->attributes()
        ;
    }
}
