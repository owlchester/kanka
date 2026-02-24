<?php

namespace App\Renderers\Layouts\Character;

use App\Facades\Module;
use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Organisation extends Layout
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
                'render' => Standard::IMAGE,
                'with' => ['target' => 'organisation'],
            ],
            'organisation' => [
                'key' => 'organisation.name',
                'label' => Module::singular(config('entities.ids.organisation'), 'entities.organisation'),
                'render' => Standard::ENTITYLINK,
                'with' => 'organisation',
            ],
            'role' => [
                'key' => 'role',
                'label' => 'organisations.members.fields.role',
                'render' => function ($model) {
                    $icon = '';
                    if ($model->inactive()) {
                        $icon = '<i class="fa-regular fa-user-slash" data-title="' . __('organisations.members.status.inactive') . '" data-toggle="tooltip"></i>';
                    } elseif ($model->unknown()) {
                        $icon = '<i class="fa-solid fa-question" data-title="' . __('organisations.members.status.unknown') . '" data-toggle="tooltip"></i>';
                    }
                    $private = '';
                    if ($model->is_private) {
                        $private = '<i class="fa-regular fa-lock" aria-hidden="true"></i> ';
                    }

                    return $icon . $private . $model->role;
                },
            ],
            'locations' => [
                'key' => 'locations.name',
                'label' => Module::plural(config('entities.ids.location'), 'entities.locations'),
                'render' => function ($model) {
                    $locations = [];
                    if ($model->organisation?->entity?->locations?->isNotEmpty()) {
                        foreach ($model->organisation->entity->locations as $location) {
                            if ($location->entity) {
                                $locations[] = '<a href="' . $location->entity->url() . '" data-toggle="tooltip-ajax" data-id="' . $location->entity->id . '" data-url="' . route('entities.tooltip', [$location->entity->campaign_id, $location->entity]) . '">' . e($location->name) . '</a>';
                            }
                        }
                    }

                    return implode(', ', $locations);
                },
            ],
            'pinned' => [
                'label' => '<i class="fa-regular fa-map-pin" data-title="' . __('organisations.members.fields.pinned') . '" data-toggle="tooltip"></i><span class="sr-only">' . __('organisations.members.fields.pinned') . '</span>',
                'render' => function ($model) {
                    if (! $model->pinned()) {
                        return '';
                    }
                    if ($model->pinnedToCharacter()) {
                        return '<i class="fa-regular fa-user" data-toggle="tooltip" data-title="' . __('entities.character') . '"></i>';
                    } elseif ($model->pinnedToOrganisation()) {
                        return '<i class="fa-regular fa-screen-users" data-toggle="tooltip" data-title="' . __('entities.organisation') . '"></i>';
                    }

                    return '<i class="fa-regular fa-map-pin" data-toggle="tooltip" data-title="' . __('organisations.members.pinned.both') . '"></i>';
                },
            ],
            'tags' => [
                'render' => Standard::TAGS,
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
            self::ACTION_EDIT_DIALOG,
            self::ACTION_DELETE,
        ];
    }
}
