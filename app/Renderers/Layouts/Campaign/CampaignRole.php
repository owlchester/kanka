<?php

namespace App\Renderers\Layouts\Campaign;

use App\Facades\CampaignLocalization;
use App\Renderers\Layouts\Layout;

class CampaignRole extends Layout
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
                'label' => 'campaigns.roles.fields.name',
                'render' => function ($model) {
                    /** @var \App\Models\CampaignRole $model */
                    $html = '<a href="' . route('campaign_roles.show', ['campaign_role' => $model])
                        . '">' . $model->name
                        . '</a><br />';

                    return $html;
                },
            ],
            'users' => [
                'label' => 'campaigns.roles.fields.users',
                'render' => function ($model) {
                    return $model->users->count();
                }
            ],
            'type' => [
                'key' => 'is_admin',
                'label' => 'campaigns.roles.fields.type',
                'render' => function ($model) {
                    /** @var \App\Models\CampaignRole $model */
                    $html =  __('campaigns.roles.types.' . ($model->is_admin ? 'owner' : ($model->is_public ? 'public' : 'standard')));

                    return $html;
                },
            ],
            'permissions' => [
                'label' => 'campaigns.roles.fields.permissions',
                'render' => function ($model) {
                    $html = '';
                    $campaign = CampaignLocalization::getCampaign();

                    /** @var \App\Models\CampaignRole $model */
                    if (!$model->is_admin) {
                        $html = '<a href="' . route('campaign_roles.show', ['campaign_role' => $model])
                            . '" title="'
                            . __('campaigns.roles.actions.permissions')
                            . '">'
                            . $model->permissions->whereNull('entity_id')->count()
                            . '</a>';
                    }
                    if ($model->is_public && !$campaign->isPublic() && $model->permissions->whereNull('entity_id')->count() > 0) {
                        $html .= '<div class="hidden-xs"> <i class="fa-solid fa-exclamation-triangle" data-toggle="tooltip" title="'
                            . __('campaigns.roles.hints.campaign_not_public')
                            . '"></i></div> <div class="visible-xs">
                                <i class="fa-solid fa-exclamation-triangle" data-toggle="collapse" data-target="#campaign-public-warning"></i>
                                <span class="collapse help-block" id="campaign-public-warning">'
                            . __('campaigns.roles.hints.campaign_not_public')
                            . '</span> </div>';
                    }

                    return $html;
                },
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
                'label' => 'campaigns.roles.actions.rename',
                'icon' => 'fa-solid fa-edit',
                'can' => 'update',
                'type' => 'ajax-modal',
                'route' => 'campaign_roles.edit',
            ],
            'show' => [
                'label' => 'campaigns.roles.actions.permissions',
                'icon' => 'fa-solid fa-edit',
                'route' => 'campaign_roles.show',
            ],
            'duplicate' => [
                'label' => 'campaigns.roles.actions.duplicate',
                'icon' => 'fa-solid fa-copy',
                'can' => 'update',
                'type' => 'ajax-modal',
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
