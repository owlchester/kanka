<?php

namespace App\Renderers\Layouts\Journal;

use App\Facades\Module;
use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Journal extends Layout
{
    /**
     * Available columns
     *
     * @return array[]
     */
    public function columns(): array
    {
        $columns = [
            'image' => [
                'render' => Standard::IMAGE,
            ],
            'journal' => [
                'key' => 'name',
                'label' => Module::singular(config('entities.ids.journal'), 'entities.journal'),
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => 'crud.fields.type',
                'render' => function (\App\Models\Journal $model) {
                    return $model->entity->type;
                },
            ],
            'date' => [
                'key' => 'date',
                'label' => 'journals.fields.date',
                'render' => function ($model) {
                    return \App\Facades\UserDate::format($model->date);
                },
            ],
            'author' => [
                'key' => 'author.name',
                'label' => 'journals.fields.author',
                'render' => Standard::ENTITYLINK,
                'with' => 'author',
            ],
            'parent' => [
                'key' => 'parent.name',
                'label' => 'crud.fields.parent',
                'render' => Standard::ParentLink,
                'visible' => function () {
                    return ! request()->has('parent_id');
                },
            ],
            'tags' => [
                'render' => Standard::TAGS,
            ],
        ];

        return $columns;
    }
}
