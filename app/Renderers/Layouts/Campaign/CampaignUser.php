<?php

namespace App\Renderers\Layouts\Campaign;

use App\Models\CampaignRole;
use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class CampaignUser extends Layout
{
    /**
     * Available columns
     *
     * @return array[]
     */
    public function columns(): array
    {
        $columns = [
            'image' => [
                'label' => '',
                'render' => function (\App\Models\CampaignUser $model) {
                    if ($model->user->hasAvatar()) {
                        return '<div class="rounded-full h-8 w-8 cover-background" style="background-image: url(' . $model->user->getAvatarUrl() . ')" data-title="' . $model->user->name . '"></div>';
                    }

                    return '<div class="rounded-full h-8 w-8 flex items-center justify-center bg-neutral text-neutral-content uppercase">' . $model->user->initials() . '</div>';
                },
            ],
            'name' => [
                'key' => 'user.name',
                'label' => 'campaigns.members.fields.name',
                'render' => function (\App\Models\CampaignUser $model) {
                    $html = '<a class="block break-all truncate" href="' . route('users.profile', [$model->user]) . '" target="_blank">' . $model->user->name . '</a>';
                    if ($model->user->isBanned()) {
                        $html .= '<i class="fa-regular fa-ban" aria-hidden="true" data-toggle="tooltip" data-title = "' . __('campaigns.members.fields.banned') . '"></i>';
                    }

                    return $html;
                },
            ],
            'roles' => [
                'key' => 'user.roles',
                'label' => 'campaigns.members.fields.roles',
                'render' => function (\App\Models\CampaignUser $model) {
                    /** @var CampaignRole[] $roles */
                    $roles = $model->user->campaignRoles->where('campaign_id', $this->campaign->id);
                    $roleLinks = [];
                    foreach ($roles as $role) {
                        if (auth()->user()->isAdmin()) {
                            $roleLinks[] = '<a href="' . route('campaign_roles.show', [$this->campaign, $role->id]) . '">' . $role->name . '</a>';
                        } else {
                            $roleLinks[] = $role->name;
                        }
                    }
                    $html = (string) implode(', ', $roleLinks);

                    if (auth()->user()->can('update', $model)) {
                        $html .= ' <i href="' . route('campaign.members.roles', [$this->campaign, $model->id]) . '" class="fa-regular fa-pencil cursor-pointer"
                            data-toggle="dialog-ajax" data-target="new-invite" data-url="' . route('campaign.members.roles', [$this->campaign, $model->id]) . '" data-tooltip data-title="' . __('campaigns/members.roles.title') . '" aria-label="' . __('campaigns/members.roles.title') . '">
                        </i>';
                    }

                    return $html;
                },
            ],
            'created_at' => [
                'key' => 'created_at',
                'label' => 'campaigns.members.fields.joined',
                'render' => Standard::SINCE,
            ],
            'last_login' => [
                'key' => 'user.last_login',
                'label' => 'campaigns.members.fields.last_login',
                'render' => function (\App\Models\CampaignUser $model) {

                    if ($model->user->has_last_login_sharing && ! empty($model->user->last_login_at)) {
                        return \Illuminate\Support\Facades\Blade::renderComponent(
                            new \App\View\Components\Since(date: $model->user->last_login_at, withTime: false)
                        );
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
            'switch' => [
                'label' => 'campaigns.members.actions.switch',
                'icon' => 'fa-regular fa-sign-in-alt',
                'can' => 'switch',
                'route' => 'identity.switch',
            ],
            'delete' => [
                'label' => 'campaigns.members.actions.remove',
                'icon' => 'fa-regular fa-trash-can',
                'can' => 'delete',
                'type' => 'dialog-ajax',
                'route' => 'campaign_users.delete',
                'css' => 'text-error hover:bg-error hover:text-error-content',
            ],
        ];
    }

    public function bulks(): array
    {
        return [
        ];
    }
}
