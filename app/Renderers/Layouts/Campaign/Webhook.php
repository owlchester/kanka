<?php

namespace App\Renderers\Layouts\Campaign;

use App\Renderers\Layouts\Layout;

class Webhook extends Layout
{
    /**
     * Available columns
     * @return array[]
     */
    public function columns(): array
    {
        $columns = [
            'action' => [
                'key' => 'action',
                'label' => 'campaigns/webhooks.fields.event',
                'render' => function ($model) {
                    /** @var \App\Models\Webhook $model */
                    return $model->actionKey();
                },
            ],
            'users' => [
                'label' => 'campaigns/webhooks.fields.type',
                'render' => function ($model) {
                    return $model->typeKey();
                }
            ],
            'message' => [
                'key' => 'message',
                'label' => 'campaigns/webhooks.fields.message',
                'render' => function ($model) {
                    /** @var \App\Models\Webhook $model */
                    return $model->message;
                },
            ],
            'url' => [
                'label' => 'campaigns/webhooks.fields.url',
                'render' => function ($model) {
                    return '<div href="#" data-toggle="tooltip" title="' . $model->url . '">' . $model->shortUrl() . '</div>';
                },
            ],

            'status' => [
                'label' => 'campaigns/webhooks.fields.active',
                'render' => function ($model) {
                    if ($model->status) {
                        return '<i class="fa-solid fa-check" aria-hidden="true"></i>';
                    }
                    return '';
                },
            ],
        ];

        return $columns;
    }

    /**
     * Available actions on each row
     */
    public function actions(): array
    {
        return [
            'update' => [
                'label' => 'campaigns/webhooks.actions.update',
                'icon' => 'fa-solid fa-edit',
                'route' => 'webhooks.edit',
            ],
            'status' => [
                'label' => 'campaigns/webhooks.actions.action',
                'icon' => 'fa-solid fa-edit',
                'type' => 'dialog-ajax',
                'route' => 'webhooks.status',
            ],
            'test' => [
                'label' => 'campaigns/webhooks.actions.test',
                'icon' => 'fa-solid fa-webhook',
                'route' => 'webhooks.test',
            ],
            Layout::ACTION_DELETE,
        ];
    }

    public function bulks(): array
    {
        return [
            [
                'action' => 'enable',
                'label' => 'campaigns/webhooks.actions.bulks.enable',
                'icon' => 'fa-solid fa-check',
                'can' => 'campaign:update',
            ],
            [
                'action' => 'disable',
                'label' => 'campaigns/webhooks.actions.bulks.disable',
                'icon' => 'fa-solid fa-ban',
                'can' => 'campaign:update',
            ],
            self::ACTION_DELETE,
        ];
    }
}
