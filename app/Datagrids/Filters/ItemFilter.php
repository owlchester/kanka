<?php

namespace App\Datagrids\Filters;

use App\Models\Item;

class ItemFilter extends DatagridFilter
{
    /**
     * Filters available for items
     */
    public function __construct()
    {
        $this
            ->add('name')
            ->add('type')
            ->add('price')
            ->add('size')
            ->add([
                'field' => 'item_id',
                'label' => __('crud.fields.parent'),
                'type' => 'select2',
                'route' => route('items.find'),
                'placeholder' =>  __('crud.placeholders.parent'),
                'model' => Item::class,
            ])
            ->location()
            ->character()
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
