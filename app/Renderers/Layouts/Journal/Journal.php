<?php

namespace App\Renderers\Layouts\Journal;

use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Journal extends Layout
{
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
            'journal' => [
                'key' => 'name',
                'label' => 'journals.fields.name',
                'render' => Standard::ENTITYLINK,
            ],
            'author' => [
                'key' => 'character.name',
                'label' => 'journals.fields.author',
                'render' => function ($model) {
                    if (!$model->character) {
                        return null;
                    }
                    return $model->character->tooltipedLink();
                },
            ],
        ];

        return $columns;
    }
}
