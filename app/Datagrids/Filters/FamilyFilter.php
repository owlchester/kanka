<?php

namespace App\Datagrids\Filters;

use App\Models\Family;

class FamilyFilter extends DatagridFilter
{
    /**
     * Filters available for families
     */
    public function build()
    {
        $this
            ->add('name')
            ->add('type')
            ->add([
                'field' => 'family_id',
                'label' => __('crud.fields.parent'),
                'type' => 'select2',
                'route' => route('search-list', [$this->campaign, config('entities.ids.family')]),
                'placeholder' =>  __('crud.placeholders.parent'),
                'model' => Family::class,
            ])
            ->location()
            ->character('member_id')
            ->add('is_extinct')
            ->isPrivate()
            ->template()
            ->hasImage()
            ->hasPosts()
            ->hasEntityFiles()
            ->hasAttributes()
            ->tags()
            ->attributes()
            ->connections()
        ;
    }
}
