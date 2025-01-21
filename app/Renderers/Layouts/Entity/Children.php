<?php

namespace App\Renderers\Layouts\Entity;

use App\Facades\Module;
use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;
use App\Traits\EntityTypeAware;

class Children extends Layout
{
    use EntityTypeAware;

    /**
     * Available columns
     * @return array[]
     */
    public function columns(): array
    {
        $columns = [
            'image' => [
                'render' => Standard::IMAGE
            ],
            'race_id' => [
                'key' => 'name',
                'label' => $this->entityType->name(),
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => 'crud.fields.type',
            ],
            'parent' => [
                'key' => 'parent.name',
                'label' => 'crud.fields.parent',
                'render' => Standard::ParentLink,
            ],
            'children' => [
                'label' => __('tags.fields.children'),
                'render' => function ($model) {
                    return $model->children->count();
                }
            ],
            'tags' => [
                'render' => Standard::TAGS
            ]
        ];

        return $columns;
    }
}
