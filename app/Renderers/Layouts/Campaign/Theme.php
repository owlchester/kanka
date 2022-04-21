<?php

namespace App\Renderers\Layouts\Campaign;

use App\Renderers\Layouts\Layout;

class Theme extends Layout
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
                'label' => 'campaigns/styles.fields.name',
                'render' => function ($model) {
                    return link_to_route('campaign_styles.edit', $model->name, $model);
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
                }
            ],
            'enabled' => [
                'key' => 'is_enabled',
                'label' => 'campaigns/styles.fields.is_enabled',
                'render' => function ($model) {
                    return $model->is_enabled ? '<i class="fa fa-check-circle"></i>' : null;
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
            self::ACTION_EDIT,
            self::ACTION_DELETE
        ];
    }

    public function bulks(): array
    {
        return [
            [
                'action' => 'enable',
                'label' => 'campaigns/styles.actions.enable',
                'icon' => 'fa-solid fa-check'
            ],
            [
                'action' => 'disable',
                'label' => 'campaigns/styles.actions.disable',
                'icon' => 'fa-solid fa-ban',
            ],
            self::ACTION_DELETE,
        ];
    }
}
