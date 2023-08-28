<?php

namespace App\Renderers\Layouts\Campaign;

use App\Facades\CampaignLocalization;
use App\Renderers\Layouts\Layout;

class CampaignUser extends Layout
{
    /**
     * Available columns
     * @return array[]
     */
    public function columns(): array
    {
        $columns = [
            'image' => [
                'label' => '',
                'render' => function ($model) {
                    $html = '<div class="entity-image pull-left" style="background-image: url(' . $model->user->getAvatarUrl() . ')" title="' . $model->user->name . '"></div>';
                    return $html;
                }
            ],
            'name' => [
                'key' => 'user.name',
                'label' => 'campaigns.members.fields.name',
                'render' => function ($model) {
                    $html = '<a class="block break-all truncate" href="' . route('users.profile', [$model->user]) . '" target="_blank">' . $model->user->name . '</a>';
                    if ($model->user->isBanned()) {
                        $html .= '<i class="fa-solid fa-ban" aria-hidden="true" data-toggle="tooltip" data-title = "' . __('campaigns.members.fields.banned') . '"></i>';
                    }
                    return $html;
                },
            ],
            'roles' => [
                'key'   => 'user.roles',
                'label' => 'campaigns.members.fields.roles',
                'render' => function ($model) {
                    $campaign = CampaignLocalization::getCampaign();
                    $html = $model->user->rolesList($campaign);
                    if (auth()->user()->can('update', $model)) {
                        $html .= ' <i href="' . route('campaign.members.roles', [$campaign, $model->id]) . '" class="fa-solid fa-plus-circle cursor-pointer"
                            data-toggle="dialog-ajax" data-target="new-invite" data-url="' . route('campaign.members.roles', [$campaign, $model->id]) . '">
                        </i>';
                    }
                    return $html;
                }
            ],
            'created_at' => [
                'key' => 'created_at',
                'label' => 'campaigns.members.fields.joined',
                'render' => function ($model) {
                    $html = '';

                    if (!empty($model->created_at)) {
                        $html = '<span data-title="' . $model->created_at . 'UTC" data-toggle="tooltip">' . $model->created_at->diffForHumans() . '</span>';
                    }
                    return $html;
                },
            ],
            'last_login' => [
                'key' => 'user.last_login',
                'label' => 'campaigns.members.fields.last_login',
                'render' => function ($model) {
                    $html = '';
                    if ($model->user->has_last_login_sharing && !empty($model->user->last_login_at)) {
                        $html = '<span data-title="' . $model->user->last_login_at . 'UTC" data-toggle="tooltip">' . $model->user->last_login_at->diffForHumans() . '</span>';
                    }
                    return $html;
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
            'switch' => [
                'label' => 'campaigns.members.actions.switch',
                'icon' => 'fa-solid fa-sign-in-alt',
                'can' => 'switch',
                'route' => 'identity.switch',
            ],
            'delete' => [
                'label' => 'campaigns.members.actions.remove',
                'icon' => 'fa-solid fa-trash',
                'can' => 'delete',
                'type' => 'dialog-ajax',
                'target' => 'member-dialog',
                'route' => 'campaign_users.delete',
            ],
        ];
    }

    public function bulks(): array
    {
        return [
        ];
    }
}
