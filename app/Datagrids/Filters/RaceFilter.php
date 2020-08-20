<?php

namespace App\Datagrids\Filters;


use App\Models\Race;

class RaceFilter extends DatagridFilter
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
                'field' => 'race_id',
                'label' => trans('characters.fields.race'),
                'type' => 'select2',
                'route' => route('races.find'),
                'placeholder' =>  trans('crud.placeholders.race'),
                'model' => Race::class,
            ])
            ->isPrivate()
            ->hasImage()
            ->tags()
        ;
    }
}
