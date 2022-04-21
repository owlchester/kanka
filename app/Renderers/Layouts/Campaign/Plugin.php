<?php

namespace App\Renderers\Layouts\Campaign;

use App\Facades\CampaignLocalization;
use App\Renderers\Layouts\Layout;

class Plugin extends Layout
{
    /**
     * Available columns
     * @return array[]
     */
    public function columns(): array
    {
        $columns = [
            'name' => [
                'key' => 'name',
                'label' => 'campaigns/plugins.fields.name',
                'render' => function ($model) {
                    $html = '<a href="' . config('marketplace.url') . '/plugins/' . $model->uuid . '" target="_blank">'
                             . $model->name
                            . '</a><br />';

                    $campaign = CampaignLocalization::getCampaign();
                    if (auth()->check() && auth()->user()->can('recover', $campaign) && $model->hasUpdate()) {
                        $html .= '<a href="' . route('campaign_plugins.update-info', $model)
                            . '" class="btn btn-xs btn-info" data-toggle="ajax-modal" '
                            . 'data-target="#entity-modal" data-url="'
                            . route('campaign_plugins.update-info', $model) . '">'
                            . __('campaigns/plugins.actions.update_available')
                            . '</a>';
                    }
                    return $html;
                },
            ],
            'type' => [
                'key' => 'type_id',
                'label' => 'campaigns/plugins.fields.type',
                'render' => function ($model) {
                    return __('campaigns/plugins.types.' . $model->type());
                },
            ],
            'status' => [
                'key' => 'pivot_is_active',
                'label' => 'campaigns/plugins.fields.status',
                'render' => function ($model) {
                    if (!$model->isTheme()) {
                        return '';
                    }
                    if($model->pivot->is_active) {
                        return
                            '<i class="fa-solid fa-check-circle" title="' .
                            __('campaigns/plugins.status.enabled') .
                            '" data-toggle="tooltip"></i>';
                    }

                    return
                        '<i class="fa-solid fa-ban" title="' .
                        __('campaigns/plugins.status.disabled') .
                        '" data-toggle="tooltip"></i>';
                }
            ],
        ];

        return $columns;
    }

    /**
     * Available actions on each row
     * @return array
     */
    public function actions(): array
    {
        return [
            'update' => [
                'label' => 'campaigns/plugins.actions.update',
                'icon' => 'fa-solid fa-download',
                'can' => 'update',
                'type' => 'ajax-modal',
                'route' => 'campaign_plugins.update-info',
            ],
            'disable' => [
                'can' => 'disable',
                'route' => 'campaign_plugins.disable',
                'label' => 'campaigns/plugins.actions.disable',
                'icon' => 'fa-solid fa-ban',
            ],
            'enable' => [
                'can' => 'enable',
                'route' => 'campaign_plugins.enable',
                'label' => 'campaigns/plugins.actions.enable',
                'icon' => 'fa-solid fa-check-circle',
            ],
            'import' => [
                'can' => 'import',
                'route' => 'campaign_plugins.confirm-import',
                'type' => 'ajax-modal',
                'label' => 'campaigns/plugins.actions.import',
                'icon' => 'fa-solid fa-check-circle',
            ],
            Layout::ACTION_DELETE,
        ];
    }

    public function bulks(): array
    {
        return [
            [
                'action' => 'enable',
                'label' => 'campaigns/plugins.actions.bulks.enable',
                'icon' => 'fa-solid fa-check',
                'can' => 'campaign:recover',
            ],
            [
                'action' => 'disable',
                'label' => 'campaigns/plugins.actions.bulks.disable',
                'icon' => 'fa-solid fa-ban',
                'can' => 'campaign:recover',
            ],
            [
                'action' => 'update',
                'label' => 'campaigns/plugins.actions.bulks.update',
                'icon' => 'fa-solid fa-download',
                'can' => 'campaign:recover',
            ],
            self::ACTION_DELETE,
        ];
    }
}
