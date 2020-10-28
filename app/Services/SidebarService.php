<?php

namespace App\Services;

use Illuminate\Support\Arr;

class SidebarService
{
    protected $rules = [
        'dashboard' => [
            null,
            'dashboard',
        ],
        'campaigns' => [
            'campaign',
            'campaigns',
            'campaign_user',
            'campaign_roles',
            'campaign_invites',
            'recovery',
        ],
        'characters' => [
            'characters',
            'character_relation',
        ],
        'conversations' => [
            'conversations',
            'conversation_messages',
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
        'maps' => [
            'maps',
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
        'tags' => [
            'tags'
        ],
        'timelines' => [
            'timelines'
        ],
        'dice_rolls' => [
            'dice_rolls',
        ],
        'menu_links' => [
            'menu_links',
        ],
        'races' => [
            'races',
        ],
        'abilities' => [
            'abilities',
        ],
    ];

    /**
     * Admin menu
     * @var array
     */
    protected $adminRules = [
        'faqs' => [
            'faqs'
        ],
        'users' => [
            'users',
        ],
        'app-releases' => [
            'app-releases',
        ],
        'community-events' => [
            'community-events',
        ],
        'community-votes' => [
            'community-votes',
        ],
        'patrons' => [
            'patrons',
        ],
        'cache' => [
            'cache',
        ],
        'referrals' => [
            'referrals',
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
            if (request()->segment(4) == $rule) {
                return " $class";
            }
        }

        // Entities? It's complicated
        if (request()->segment(4) == 'entities') {
            $entity = request()->route('entity');
            if ($entity->pluralType() == $menu) {
                return " $class";
            }
        }

        return null;
    }

    /**
     * Settings menu active
     * @param string $menu
     * @return string
     */
    public function settings(string $menu): string
    {
        $current = request()->segment(3);
        if ($current == $menu) {
            return ' active';
        }
        return '';
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
            if (request()->segment(4) == $rule) {
                return $css;
            }
        }
        return null;
    }

    /**
     * @param $menu
     * @param string $class
     * @return string|null
     */
    public function admin($menu, $class = 'active')
    {
        if (empty($this->adminRules[$menu])) {
            return null;
        }

        foreach ($this->adminRules[$menu] as $rule) {
            if (request()->segment(3) == $rule) {
                return " $class";
            }
        }

        return null;
    }
}
