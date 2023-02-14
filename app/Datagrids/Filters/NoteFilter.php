<?php

namespace App\Datagrids\Filters;

use App\Models\Note;

class NoteFilter extends DatagridFilter
{
    /**
     * Filters available for notes
     */
    public function build()
    {
        $this
            ->add('name')
            ->add('type')
            ->add([
                'field' => 'note_id',
                'label' => __('notes.fields.note'),
                'type' => 'select2',
                'route' => route('notes.find', $this->campaign),
                'placeholder' =>  __('crud.placeholders.note'),
                'model' => Note::class,
            ])
            ->isPrivate()
            ->template()
            ->hasImage()
            ->hasPosts()
            ->hasEntityFiles()
            ->hasAttributes()
            ->tags()
            ->attributes()
        ;
    }
}
