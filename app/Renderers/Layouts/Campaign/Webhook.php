<?php

namespace App\Renderers\Layouts\Campaign;

use App\Renderers\Layouts\Layout;
use Illuminate\Support\Str;

class Webhook extends Layout
{
    /**
     * Available columns
     *
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
            'type' => [
                'key' => 'type',
                'label' => 'campaigns/webhooks.fields.type',
                'render' => function ($model) {
                    return $model->typeKey();
                },
            ],
            'message' => [
                'label' => 'campaigns/webhooks.fields.message',
                'render' => function ($model) {
                    /** @var \App\Models\Webhook $model */
                    return '<div data-toggle="tooltip" data-title="' . nl2br($model->message) . '" data-html="1">'
                        . Str::limit(strip_tags($model->message ?? ''), 30)
                        . '</div>';
                },
            ],
            'url' => [
                'label' => 'campaigns/webhooks.fields.url',
                'render' => function ($model) {
                    return '<div data-toggle="tooltip" data-title="' . $model->url . '">'
                        . $model->shortUrl()
                        . '</div>';
                },
            ],

            'status' => [
                'key' => 'status',
                'label' => 'campaigns/webhooks.fields.enabled',
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
                'label' => 'crud.update',
                'icon' => 'fa-solid fa-edit',
                'route' => 'webhooks.edit',
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
