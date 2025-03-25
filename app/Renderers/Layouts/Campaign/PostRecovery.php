<?php

namespace App\Renderers\Layouts\Campaign;

use App\Renderers\Layouts\Layout;

class PostRecovery extends Layout
{
    /**
     * Available columns
     *
     * @return array[]
     */
    public function columns(): array
    {
        $columns = [
            'name' => [
                'key' => 'name',
                'label' => 'crud.fields.name',
            ],
            'deleted' => [
                'key' => 'deleted_at',
                'label' => 'campaigns/recovery.fields.deleted',
                'class' => self::ONLY_DESKTOP,
                'render' => function ($post) {
                    return $post->deleted_at->diffForHumans();
                },
            ],
        ];

        return $columns;
    }

    /**
     * Bulk actions
     */
    public function bulks(): array
    {
        return [
            [
                'action' => 'recover',
                'label' => 'campaigns/recovery.actions.recover',
                'icon' => 'fa-solid fa-history',
                'can' => 'campaign:recover',
            ],
        ];
    }
}
