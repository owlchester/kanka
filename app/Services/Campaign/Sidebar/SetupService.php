<?php

namespace App\Services\Campaign\Sidebar;

use App\Facades\Module;
use App\Models\EntityType;
use App\Traits\CampaignAware;
use App\Traits\RequestAware;
use App\Traits\UserAware;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class SetupService
{
    use CampaignAware;
    use RequestAware;
    use UserAware;

    protected array $elements;

    protected $layout = [
        'dashboard' => null,
        'bookmarks' => null,
        'world' => [ // world
            'characters',
            'locations',
            'maps',
            'organisations',
            'families',
            'creatures',
            'races',
        ],
        'time' => [
            'calendars',
            'timelines',
            'events',
            'journals',
        ],
        'game' => [
            'quests',
            'items',
            'abilities',
        ],
        'notes' => null,
        'other' => [
            'tags',
            'conversations',
            'dice_rolls',
            'relations',
            'attribute_templates',
            'whiteboards',
        ],
        'gallery' => null,
        'history' => null,
        'settings' => null,
        // 'search' => null,
    ];

    protected $modules = [];

    public function __construct()
    {
        $this->setupElements();
    }

    protected function setupElements(): void
    {
        $this->elements = [
            'dashboard' => [
                'icon' => 'fa-duotone fa-house',
                'label' => 'sidebar.dashboard',
                'module' => false,
                'route' => 'dashboard',
                'fixed' => true,
            ],
            'bookmarks' => [
                'type' => 'bookmark',
                'fixed' => true,
            ],
            'world' => [
                'icon' => 'fa-duotone fa-mountains',
                'label' => 'sidebar.world',
                'module' => false,
                'fixed' => true,
                'route' => false,
            ],
            'characters' => [
                'type' => 'character',
                'mode' => true,
            ],
            'locations' => [
                'type' => 'location',
                'mode' => true,
            ],
            'maps' => [
                'mode' => true,
                'type' => 'map',
            ],
            'organisations' => [
                'mode' => true,
                'type' => 'organisation',
            ],
            'families' => [
                'mode' => true,
                'type' => 'family',
            ],
            'calendars' => [
                'mode' => true,
                'type' => 'calendar',
            ],
            'timelines' => [
                'mode' => true,
                'type' => 'timeline',
            ],
            'races' => [
                'mode' => true,
                'type' => 'race',
            ],
            'creatures' => [
                'mode' => true,
                'type' => 'creature',
            ],
            'game' => [
                'icon' => 'fa-duotone fa-book',
                'label' => 'sidebar.game',
                'route' => false,
                'fixed' => true,
            ],
            'quests' => [
                'mode' => true,
                'type' => 'quest',
            ],
            'journals' => [
                'mode' => true,
                'type' => 'journal',
            ],
            'items' => [
                'mode' => true,
                'type' => 'item',
            ],
            'events' => [
                'mode' => true,
                'type' => 'event',
            ],
            'abilities' => [
                'mode' => true,
                'type' => 'ability',
            ],
            'notes' => [
                'mode' => true,
                'type' => 'note',
            ],
            'other' => [
                'icon' => 'fa-duotone fa-database',
                'label' => 'sidebar.other',
                'module' => false,
                'route' => false,
                'fixed' => true,
            ],
            'time' => [
                'icon' => 'fa-duotone fa-hourglass',
                'label' => 'sidebar.time',
                'module' => false,
                'route' => false,
                'fixed' => true,
            ],
            'tags' => [
                'mode' => true,
                'type' => 'tag',
            ],
            'conversations' => [
                'type' => 'conversation',
            ],
            'dice_rolls' => [
                'type' => 'dice_roll',
            ],
            'relations' => [
                'icon' => 'fa-duotone fa-circle-nodes',
                'label' => 'sidebar.relations',
                'perm' => 'relations',
                'module' => false,
            ],
            'gallery' => [
                'icon' => 'fa-duotone fa-images',
                'label' => 'sidebar.gallery',
                'route' => 'gallery',
                'perm' => 'gallery',
                'module' => false,
            ],
            'attribute_templates' => [
                'type' => 'attribute_template',
            ],
            'whiteboards' => [
                'type' => 'whiteboard',
            ],
            'settings' => [
                'icon' => 'fa-duotone fa-cog',
                'label' => 'sidebar.settings',
                'module' => false,
                'fixed' => true,
                'route' => 'overview',
            ],
            /*'search' => [
            'icon' => 'fa fa-search',
            'label' => 'Search...',
            'module' => false,
            'route' => 'search',
        ],*/
            'history' => [
                'icon' => 'fa-duotone fa-clock-rotate-left',
                'label' => 'sidebar.recent',
                'perm' => 'recover',
                'module' => false,
                'fixed' => true,
            ],
        ];
    }

    protected bool $withDisabled = false;

    public function withDisabled(): self
    {
        $this->withDisabled = true;

        return $this;
    }

    /**
     * Generate an array of the sidebar elements
     */
    public function layout(): array
    {
        $key = $this->cacheKey();
        if (! $this->withDisabled && Cache::has($key)) {
            return Cache::get($key);
        }
        $this->loadModules();
        $layout = [];
        $layoutSetup = $this->customLayout();
        $rewrite = [];
        foreach ($layoutSetup as $name => $children) {
            // We migrated to a new structure, but have the setup in json, so we need to "fix it" here
            if (in_array($name, $rewrite)) {
                continue;
            }
            if ($name === 'menu_links') {
                $name = 'bookmarks';
            } elseif ($name === 'campaigns') {
                $name = 'world';
                $rewrite[] = 'world';
            } elseif ($name === 'campaign') {
                $name = 'game';
                $rewrite[] = 'game';
            }
            if (! isset($this->elements[$name])) {
                dd('E601 - cant find element ' . $name);
            }
            $element = $this->customElement($name);
            // Add a route if it should have one
            if (! isset($element['route'])) {
                $element['route'] = $name . '.index';
            }

            // No children? Nothing more to do
            if (empty($children)) {
                // If this is a level 0 element like "Notes", the module still needs to be checked
                if (! isset($element['module']) && ! $this->withDisabled) {
                    if (! $this->campaign->enabled($name)) {
                        continue;
                    }
                }
                $layout[$name] = $element;

                continue;
            }
            $layout[$name] = $element;
            $layout[$name]['children'] = [];
            foreach ($children as $childName) {
                $child = $this->customElement($childName);
                // Child has a module, check that the campaign has it enabled
                if (! isset($child['module'])) {
                    if (! $this->campaign->enabled($childName)) {
                        if ($this->withDisabled) {
                            $child['disabled'] = true;
                        } else {
                            continue;
                        }
                    }
                }
                // Child has permission check?
                if (isset($child['perm']) && count($children) === 1) {
                    $layout[$name]['perm'] = $child['perm'];
                }

                // Add route when none is set
                if (! isset($child['route'])) {
                    $child['route'] = $childName . '.index';
                }

                // Add it
                $layout[$name]['children'][$childName] = $child;
            }
        }

        if (! $this->withDisabled) {
            Cache::put($key, $layout, 7 * 86400);
        }

        return $layout;
    }

    protected function customLayout(): array
    {
        // Only boosted campaigns can change the layout
        if (! $this->campaign->boosted()) {
            return $this->layout;
        }
        $layout = Arr::get($this->campaign->ui_settings, 'sidebar.order');
        if (empty($layout)) {
            return $this->layout;
        }

        // We have a layout, let's see if anything is missing. There is probably a smarter way to do this.
        $definedElements = [];
        foreach ($layout as $name => $values) {
            $definedElements[] = $name;
            if (! is_array($values)) {
                continue;
            }
            foreach ($values as $key) {
                $definedElements[] = $key;
            }
        }

        // Find missing elements that are in the base layout but not in the custom one
        $missing = array_diff(array_keys($this->elements), $definedElements);

        // Loop through the missing elements and inject them where they are "expected"
        foreach ($missing as $element) {
            $found = false;
            // dump('Missing: ' . $element);
            // If it's a base level, add it there
            if (array_key_exists($element, $this->layout)) {
                $layout[$element] = null;

                continue;
            }
            foreach ($this->layout as $name => $children) {
                if (! is_array($children)) {
                    continue;
                }
                $values = array_values($children);
                // dump(!in_array($element, $values));
                if (! in_array($element, $values)) {
                    continue;
                }
                $layout[$name][$element] = $element;
                // dump('Added it to ' . $name);

                $found = true;

                continue;
            }

            if (! $found) {
                dd('E637: Couldn\'t place sidebar element ' . $element);
            }
        }

        return $layout;
    }

    /**
     * Load custom element setup for boosted campaigns
     */
    protected function customElement(string $key): array
    {
        $element = $this->elements[$key];

        if (isset($element['type'])) {
            $entityType = $this->modules[$element['type']];
            $element['label'] = $entityType->name();
            $element['icon'] = $entityType->icon();
        }

        $element['label_key'] = $element['label'];
        unset($element['label']);

        if (! $this->campaign->boosted()) {
            return $element;
        }

        // Module custom name
        if (! empty($element['type_id']) && ! $this->withDisabled) {
            $type = $element['type_id'];
            $label = Module::plural($type);
            if (! empty($label)) {
                $element['custom_label'] = $label;
            }
            $icon = Module::icon($type);
            if (! empty($icon)) {
                $element['custom_icon'] = $icon;
            }
        }

        $label = Arr::get($this->campaign->ui_settings, 'sidebar.labels.' . $key);
        $icon = Arr::get($this->campaign->ui_settings, 'sidebar.icons.' . $key);
        if (! empty($label)) {
            $element['custom_label'] = $label;
        }
        if (! empty($icon)) {
            $element['custom_icon'] = $icon;
        }

        return $element;
    }

    protected function cacheKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_sidebar';
    }

    /**
     * Available parents for placing a quick link
     */
    public function availableParents(): array
    {
        $labels = [];
        foreach ($this->elements as $key => $element) {
            $labels[$key] = __($element['label']);
        }

        return $labels;
    }

    protected function loadModules(): void
    {
        $modules = EntityType::default()->get();
        /** @var EntityType $module */
        foreach ($modules as $module) {
            $this->modules[$module->code] = $module;
        }
    }
}
