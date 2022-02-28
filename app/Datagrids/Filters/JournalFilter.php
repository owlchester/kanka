<?php

namespace App\Datagrids\Filters;

use App\Models\Entity;

class JournalFilter extends DatagridFilter
{
    /**
     * CharacterFilter constructor.
     */
    public function __construct()
    {
        $this
            ->add('name')
            ->add('type')
            ->date()
            ->add([
                    'field' => 'author_id',
                    'label' => trans('journals.fields.author'),
                    'type' => 'select2',
                    'route' => route('search.entities-with-relations'),
                    'placeholder' =>  trans('journals.placeholders.author'),
                    'model' => Entity::class,
            ])
            ->location()
            ->isPrivate()
            ->hasImage()
            ->hasEntityNotes()
            ->hasEntityFiles()
            ->hasAttributes()
            ->tags()
            ->attributes()
        ;
    }
}
