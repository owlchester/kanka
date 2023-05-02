<?php

namespace App\Datagrids\Filters;

use App\Facades\Module;
use App\Models\Tag;

class TagFilter extends DatagridFilter
{
    /**
     * Filters available for tags
     */
    public function __construct()
    {
        $name = Module::singular(config('entities.ids.tag'));
        $placeholder = __('crud.placeholders.tag');
        if (!empty($name)) {
            $placeholder = __('crud.placeholders.fallback', ['module' => $name]);
        }
        $this
            ->add('name')
            ->add('type')
            ->add([
                'field' => 'tag_id',
                'label' => Module::singular(config('entities.ids.tag'), __('entities.tag')),
                'type' => 'select2',
                'route' => route('tags.find'),
                'placeholder' =>  $placeholder,
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
