<?php

namespace App\Datagrids\Filters;

use App\Models\Family;
use App\Models\Character;

class FamilyFilter extends DatagridFilter
{
    /**
     * Filters available for families
     */
    public function __construct()
    {
        $this
            ->add('name')
            ->add('type')
            ->add([
                'field' => 'family_id',
                'label' => __('crud.fields.parent'),
                'type' => 'select2',
                'route' => route('families.find'),
                'placeholder' =>  __('crud.placeholders.parent'),
                'model' => Family::class,
            ])
            ->location()
            ->character('member_id')
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
