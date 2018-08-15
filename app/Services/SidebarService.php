<?php

namespace App\Services;

class SidebarService
{
    protected $rules = [
        'dashboard' => [
            null,
            'dashboard',
        ],
        'campaigns' => [
            'campaigns',
            'campaign_user',
            'campaign_roles',
            'campaign_invites',
        ],
        'characters' => [
            'characters',
            'character_relation',
        ],
        'events' => [
            'events',
        ],
        'families' => [
            'families',
            'family_relation',
        ],
        'items' => [
            'items',
        ],
        'journals' => [
            'journals',
        ],
        'locations' => [
            'locations',
        ],
        'notes' => [
            'notes',
        ],
        'organisations' => [
            'organisations',
            'organisation_member',
        ],
        'other' => [
            'releases',
            'team',
        ],
        'quests' => [
            'quests',
        ],
        'calendars' => [
            'calendars',
        ],
        'releases' => [
            'releases'
        ],
        'team' => [
            'team',
        ],
        'attribute_templates' => [
            'attribute_templates',
        ],
        'sections' => [
            'sections'
        ],
        'dice_rolls' => [
            'dice_rolls',
        ],
    ];

    /**
     * @param $menu
     */
    public function active($menu = '', $class = 'active')
    {
        if (empty($this->rules[$menu])) {
            return null;
        }

        foreach ($this->rules[$menu] as $rule) {
            if (request()->segment(3) == $rule) {
                return " $class";
            }
        }

        // Entities? It's complicated
        if (request()->segment(3) == 'entities') {
            $entity = request()->route('entity');
            if ($entity->pluralType() == $menu) {
                return " $class";
            }
        }

        return null;
    }

    /**
     * @param string $menu
     * @param string $css
     * @return null|string
     */
    public function open($menu = '', $css = 'menu-open')
    {
        if (empty($this->rules[$menu])) {
            return null;
        }

        foreach ($this->rules[$menu] as $rule) {
            if (request()->segment(2) == $rule) {
                return $css;
            }
        }
        return null;
    }
}
