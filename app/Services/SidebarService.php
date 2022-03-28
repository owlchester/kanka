<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\MenuLink;
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
        'relations' => [
            'relations',
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
        'faq' => [
            'faq',
            'faqs',
        ],
        'faq-categories' => [
            'faq-categories',
        ],
        'cache' => [
            'cache',
        ],
        'referrals' => [
            'referrals',
        ],
    ];

    protected $elements = [
        'dashboard' => [
            'icon' => 'fas fa-th-large',
            'label' => 'sidebar.dashboard',
            'module' => false,
            'route' => 'dashboard',
        ],
        'menu_links' => [
            'icon' => 'fa fa-star',
            'label' => 'entities.menu_links',
        ],
        'campaigns' => [
            'icon' => 'fa fa-globe',
            'label' => 'sidebar.world',
            'module' => false,
            'route' => 'campaign',
        ],
        'characters' => [
            'icon' => 'fa fa-user',
            'label' => 'sidebar.characters',
        ],
        'locations' => [
            'icon' => 'ra ra-tower',
            'label' => 'sidebar.locations',
        ],
        'maps' => [
            'icon' => 'fas fa-map',
            'label' => 'entities.maps',
        ],
        'organisations' => [
            'icon' => 'ra ra-hood',
            'label' => 'sidebar.organisations',
        ],
        'families' => [
            'icon' => 'ra ra-double-team',
            'label' => 'sidebar.families',
        ],
        'calendars' => [
            'icon' => 'fa fa-calendar',
            'label' => 'sidebar.calendars',
        ],
        'timelines' => [
            'icon' => 'fas fa-hourglass-half',
            'label' => 'sidebar.timelines',
        ],
        'races' => [
            'icon' => 'ra ra-wyvern',
            'label' => 'sidebar.races',
        ],
        'campaign' => [
            'icon' => 'fa fa-globe',
            'label' => 'sidebar.campaign',
            'route' => 'campaign',
        ],
        'quests' => [
            'icon' => 'ra ra-wooden-sign',
            'label' => 'sidebar.quests'
        ],
        'journals' => [
            'icon' => 'ra ra-quill-ink',
            'label' => 'sidebar.journals'
        ],
        'items' => [
            'icon' => 'ra ra-gem-pendant',
            'label' => 'sidebar.items'
        ],
        'events' => [
            'icon' => 'fa fa-bolt',
            'label' => 'sidebar.events'
        ],
        'abilities' => [
            'icon' => 'ra ra-fire-symbol',
            'label' => 'sidebar.abilities'
        ],
        'notes' => [
            'icon' => 'fas fa-book-open',
            'label' => 'sidebar.notes',
        ],
        'other' => [
            'icon' => 'fas fa-cubes',
            'label' => 'sidebar.other',
            'module' => false,
            'route' => false,
        ],
        'tags' => [
            'icon' => 'fa fa-tags',
            'label' => 'sidebar.tags',
        ],
        'conversations' => [
            'icon' => 'fa fa-comment',
            'label' => 'sidebar.conversations',
        ],
        'dice_rolls' => [
            'icon' => 'ra ra-dice-five',
            'label' => 'sidebar.dice_rolls',
        ],
        'relations' => [
            'icon' => 'fas fa-people-arrows',
            'label' => 'sidebar.relations',
            'perm' => 'relations',
            'module' => false,
        ],
        'gallery' => [
            'icon' => 'fas fa-images',
            'label' => 'sidebar.gallery',
            'perm' => 'gallery',
            'route' => 'campaign.gallery.index',
            'module' => false,
        ],
        'attribute_templates' => [
            'icon' => 'fa fa-copy',
            'label' => 'sidebar.attribute_templates',
            'module' => false,
        ],
    ];

    protected $layout = [
        'dashboard' => null,
        'menu_links' => null,
        'campaigns' => [ //world
            'characters',
            'locations',
            'maps',
            'organisations',
            'families',
            'calendars',
            'timelines',
            'races',
        ],
        'campaign' => [
            'quests',
            'journals',
            'items',
            'events',
            'abilities',
        ],
        'notes' => null,
        'other' => [
            'tags',
            'conversations',
            'dice_rolls',
            'relations',
            'gallery',
            'attribute_templates',
        ]
    ];

    /** @var Campaign */
    protected $campaign;

    public function campaign(Campaign $campaign): self
    {
        $this->campaign = $campaign;
        return $this;
    }

    /**
     * @param $menu
     */
    public function active($menu = '', $class = 'active'): string
    {
        if (empty($this->rules[$menu])) {
            return '';
        }

        if (request()->has('quick-link')) {
            return '';
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

        return '';
    }

    /**
     * @param MenuLink $menuLink
     * @return string
     */
    public function activeMenuLink(MenuLink $menuLink): string
    {
        $request = request()->get('quick-link');
        if (empty($request) || $request != $menuLink->id) {
            return '';
        }

        return 'active';
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

    /**
     * Generate an array of the sidebar elements
     * @return array
     */
    public function layout(): array
    {
        $layout = [];
        foreach ($this->layout as $name => $children) {
            if (!isset($this->elements[$name])) {
                dd('cant find element ' . $name);
            }
            $element = $this->elements[$name];
            // Add route if should have one
            if (!isset($element['route'])) {
                $element['route'] = $name . '.index';
            }
            $element['label'] = __($element['label']);
            $layout[$name] = $element;

            // No children? Nothing more to do
            if (empty($children)) {
                continue;
            }
            $layout[$name]['children'] = [];
            foreach ($children as $childName) {
                $child = $this->elements[$childName];
                // Child has a module, check that the campaign has it enabled
                if (!isset($child['module'])) {
                    if (!$this->campaign->enabled($childName)) {
                        continue;
                    }
                }
                // Child has permission check?
                if (isset($child['perm'])) {
                    if (!auth()->check() || !auth()->user()->can($childName, $this->campaign)) {
                        continue;
                    }
                }

                // Add route when none is set
                if (!isset($child['route'])) {
                    $child['route'] = $childName . '.index';
                }
                $child['label'] = __($child['label']);

                // Add it
                $layout[$name]['children'][$childName] = $child;
            }
        }

        return $layout;
    }
}
