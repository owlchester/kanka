<?php

namespace App\Renderers\Layouts\Campaign;

use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class CampaignRole extends Layout
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
                'label' => 'campaigns.roles.fields.name',
                'render' => function ($model) {
                    /** @var \App\Models\CampaignRole $model */
                    $html = '<a href="' . route('campaign_roles.show', [$this->campaign, 'campaign_role' => $model])
                        . '" class="text-link">' . $model->name
                        . '</a><br />';

                    return $html;
                },
            ],
            'users' => [
                'label' => 'campaigns.roles.fields.users',
                'render' => function ($model) {
                    return number_format($model->users_count);
                },
            ],
            'type' => [
                'key' => 'is_admin',
                'label' => 'campaigns.roles.fields.type',
                'render' => function ($model) {
                    /** @var \App\Models\CampaignRole $model */
                    $html = __('campaigns.roles.types.' . ($model->isAdmin() ? 'owner' : ($model->isPublic() ? 'public' : 'standard')));

                    return $html;
                },
            ],
            'permissions' => [
                'label' => 'campaigns.roles.fields.permissions',
                'render' => Standard::VIEW,
                'with' => 'campaigns.roles.rows.permissions',
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
                'label' => 'campaigns.roles.actions.rename',
                'icon' => 'fa-regular fa-edit',
                'can' => 'update',
                'type' => 'dialog-ajax',
                'route' => 'campaign_roles.edit',
            ],
            'show' => [
                'label' => 'campaigns.roles.actions.permissions',
                'icon' => 'fa-regular fa-cog',
                'route' => 'campaign_roles.show',
            ],
            'duplicate' => [
                'label' => 'campaigns.roles.actions.duplicate',
                'icon' => 'fa-regular fa-copy',
                'can' => 'update',
                'type' => 'dialog-ajax',
                'route' => 'campaign_roles.duplicate',
            ],
            Layout::ACTION_DELETE,
        ];
    }

    public function bulks(): array
    {
        return [
            self::ACTION_DELETE,
        ];
    }
}
