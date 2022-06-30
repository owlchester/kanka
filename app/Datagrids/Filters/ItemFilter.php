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
                'label' => __('items.fields.item'),
                'type' => 'select2',
                'route' => route('items.find'),
                'placeholder' =>  __('items.placeholders.item'),
                'model' => Item::class,
            ])
            ->location()
            ->character()
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
