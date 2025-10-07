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
                'label' => __('crud.fields.parent'),
                'type' => 'select2',
                'route' => route('search-list', [$this->campaign, config('entities.ids.note')]),
                'placeholder' => __('crud.placeholders.parent'),
                'model' => Note::class,
            ])
            ->isPrivate()
            ->template()
            ->archived()
            ->hasImage()
            ->hasEntry()
            ->hasPosts()
            ->hasEntityFiles()
            ->hasAttributes()
            ->tags()
            ->attributes()
            ->connections();
    }
}
