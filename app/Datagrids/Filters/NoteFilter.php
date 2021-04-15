<?php

namespace App\Datagrids\Filters;

use App\Models\Note;

class NoteFilter extends DatagridFilter
{
    /**
     * CharacterFilter constructor.
     */
    public function __construct()
    {
        $this
            ->add('name')
            ->add('type')
            ->add([
                'field' => 'note_id',
                'label' => __('notes.fields.note'),
                'type' => 'select2',
                'route' => route('notes.find'),
                'placeholder' =>  trans('notes.placeholders.note'),
                'model' => Note::class,
            ])
            ->isPrivate()
            ->hasImage()
            ->hasEntityNotes()
            ->hasEntityFiles()
            ->tags()
        ;
    }
}
