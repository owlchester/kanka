<?php

namespace App\Renderers\Layouts\Campaign;

use App\Renderers\Layouts\Layout;

class Theme extends Layout
{
    /**
     * Available columns
     *
     * @return array[]
     */
    public function columns(): array
    {
        $columns = [
            'order' => [
                'key' => 'order',
                'label' => 'campaigns/styles.fields.order',
                'render' => function ($model) {
                    return $model->order ? '#' . $model->order : null;
                },
            ],
            'name' => [
                'key' => 'name',
                'label' => 'campaigns/styles.fields.name',
                'render' => function ($model) {
                    return '<a href="' . route('campaign_styles.edit', [$this->campaign, $model]) . '">' . $model->name . '</a>';
                },
            ],
            'length' => [
                'label' => 'campaigns/styles.fields.length',
                'class' => self::ONLY_DESKTOP,
                'render' => 'length()',
            ],
            'modified' => [
                'key' => 'updated_at',
                'label' => 'campaigns/styles.fields.modified',
                'class' => self::ONLY_DESKTOP,
                'render' => function ($model) {
                    return $model->updated_at->diffForHumans();
                },
            ],
            'enabled' => [
                'key' => 'is_enabled',
                'label' => 'campaigns/styles.fields.is_enabled',
                'render' => function (\App\Models\CampaignStyle $model) {
                    return $model->is_enabled ? '<i class="fa-regular fa-check-circle" aria-hidden="true"></i><span class="sr-only">' . __('campaigns/styles.fields.is_enabled') . '</span>' : null;
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
            'disable' => [
                'can' => 'disable',
                'route' => 'campaign_styles.toggle',
                'label' => 'campaigns/styles.actions.disable',
                'icon' => 'fa-regular fa-ban',
            ],
            'enable' => [
                'can' => 'enable',
                'route' => 'campaign_styles.toggle',
                'label' => 'campaigns/styles.actions.enable',
                'icon' => 'fa-regular fa-check',
            ],
            self::ACTION_EDIT,
            self::ACTION_DELETE,
        ];
    }

    public function bulks(): array
    {
        return [
            [
                'action' => 'enable',
                'label' => 'campaigns/styles.actions.enable',
                'icon' => 'fa-regular fa-check',
            ],
            [
                'action' => 'disable',
                'label' => 'campaigns/styles.actions.disable',
                'icon' => 'fa-regular fa-ban',
            ],
            self::ACTION_DELETE,
        ];
    }
}
