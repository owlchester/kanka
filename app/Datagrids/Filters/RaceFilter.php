<?php

namespace App\Datagrids\Filters;

use App\Models\Race;

class RaceFilter extends DatagridFilter
{
    /**
     * Filters available for races
     */
    public function __construct()
    {
        $this
            ->add('name')
            ->add('type')
            ->add([
                'field' => 'race_id',
                'label' => __('characters.fields.race'),
                'type' => 'select2',
                'route' => route('races.find'),
                'placeholder' =>  __('crud.placeholders.race'),
                'model' => Race::class,
            ])
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
