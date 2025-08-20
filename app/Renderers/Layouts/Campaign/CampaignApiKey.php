<?php

namespace App\Renderers\Layouts\Campaign;

use App\Renderers\Layouts\Layout;

class CampaignApiKey extends Layout
{
    /**
     * Available columns
     *
     * @return array[]
     */
    public function columns(): array
    {
        $columns = [
            'provider' => [
                'key' => 'provider',
                'label' => 'campaigns/api-keys.fields.provider',
                'render' => function (\App\Models\CampaignApiKey $model) {
                    /** @var \App\Models\CampaignApiKey $model */
                    return $model->provider;
                },
            ],
            'model' => [
                'key' => 'model',
                'label' => 'campaigns/api-keys.fields.model',
                'render' => function (\App\Models\CampaignApiKey $model) {
                    return $model->model;
                },
            ],
            'api_key' => [
                'label' => 'campaigns/api-keys.fields.api-key',
                'render' => function (\App\Models\CampaignApiKey $model) {
                    /** @var \App\Models\CampaignApiKey $model */

                   return '********' . substr($model->api_key, -4);
                },
            ],
            'is_enabled' => [
                'key' => 'is_enabled',
                'label' => 'campaigns/webhooks.fields.enabled',
                'render' => function (\App\Models\CampaignApiKey $model) {
                    if ($model->isEnabled()) {
                        return '<i class="fa-regular fa-check-circle" aria-hidden="true"></i><span class="sr-only">' . __('campaigns/webhooks.fields.enabled') . '</span>';
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
                'icon' => 'fa-regular fa-edit',
                'route' => 'api-keys.edit',
            ],
            Layout::ACTION_DELETE,
        ];
    }
}
