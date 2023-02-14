<?php

namespace App\Datagrids\Filters;

use App\Models\Tag;

class TagFilter extends DatagridFilter
{
    /**
     * Filters available for tags
     */
    public function build()
    {
        $this
            ->add('name')
            ->add('type')
            ->add([
                'field' => 'tag_id',
                'label' => __('entities.tag'),
                'type' => 'select2',
                'route' => route('tags.find', $this->campaign),
                'placeholder' =>  __('crud.placeholders.tag'),
                'model' => Tag::class,
            ])
            ->add('is_auto_applied')
            ->isPrivate()
            ->template()
            ->hasImage()
            ->hasPosts()
            ->hasEntityFiles()
            ->hasAttributes()
            ->attributes()
        ;
    }
}
