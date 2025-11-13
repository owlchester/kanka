<?php

namespace App\Datagrids\Filters;

use App\Models\Item;

class ItemFilter extends DatagridFilter
{
    /**
     * Filters available for items
     */
    public function build()
    {
        $this
            ->add('name')
            ->add('type')
            ->add('price')
            ->add('size')
            ->add('weight')
            ->add('is_equipped')
            ->add([
                'field' => 'item_id',
                'label' => __('crud.fields.parent'),
                'type' => 'select2',
                'route' => route('search-list', [$this->campaign, config('entities.ids.item')]),
                'placeholder' => __('crud.placeholders.parent'),
                'model' => Item::class,
            ])
            ->location()
            ->character()
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
