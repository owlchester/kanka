<?php


namespace App\Datagrids\Filters;



use App\Models\Location;
use App\Models\Tag;

class LocationFilter extends DatagridFilter
{
    /**
     * @return array
     */
    public function filters(): array
    {
        return [
            'name',
            'type',
            [
                'field' => 'parent_location_id',
                'label' => trans('crud.fields.location'),
                'type' => 'select2',
                'route' => route('locations.find'),
                'placeholder' =>  trans('crud.placeholders.location'),
                'model' => Location::class,
            ],
            [
                'field' => 'tag_id',
                'label' => trans('crud.fields.tag'),
                'type' => 'select2',
                'route' => route('tags.find'),
                'placeholder' =>  trans('crud.placeholders.tag'),
                'model' => Tag::class,
            ],
        ];
    }
}
