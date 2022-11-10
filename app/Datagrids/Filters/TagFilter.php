<?php

namespace App\Datagrids\Filters;

use App\Models\Tag;

class TagFilter extends DatagridFilter
{
    /**
     * Filters available for tags
     */
    public function __construct()
    {
        $this
            ->add('name')
            ->add('type')
            ->add([
                'field' => 'tag_id',
                'label' => __('entities.tag'),
                'type' => 'select2',
                'route' => route('tags.find'),
                'placeholder' =>  __('crud.placeholders.tag'),
                'model' => Tag::class,
            ])
            ->add('is_auto_applied')
            ->isPrivate()
            ->template()
            ->hasImage()
            ->hasEntityNotes()
            ->hasEntityFiles()
            ->hasAttributes()
            ->attributes()
        ;
    }
}
