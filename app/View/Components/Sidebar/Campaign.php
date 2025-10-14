<?php

namespace App\View\Components\Sidebar;

use App\Models\Bookmark;
use App\Models\Entity;
use App\Services\Campaign\Sidebar\SetupService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Campaign extends Component
{
    public array $layout;

    protected array $rules = [
        'dashboard' => [
            null,
            'dashboard',
            'dashboard-setup',
        ],
        'characters' => [
            'characters',
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
            'releases',
        ],
        'team' => [
            'team',
        ],
        'attribute_templates' => [
            'attribute_templates',
        ],
        'tags' => [
            'tags',
        ],
        'timelines' => [
            'timelines',
        ],
        'dice_rolls' => [
            'dice_rolls',
            'dice_roll_results',
        ],
        'bookmarks' => [
            'bookmarks',
        ],
        'races' => [
            'races',
        ],
        'creatures' => [
            'creatures',
        ],
        'abilities' => [
            'abilities',
        ],
        'whiteboards' => [
            'whiteboards',
        ],
        'relations' => [
            'relations',
        ],
        'history' => [
            'history',
        ],
        'gallery' => [
            'gallery',
        ],
    ];

    protected array $bookmarks;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public \App\Models\Campaign $campaign,
        protected SetupService $sidebar)
    {
        $sidebar
            ->campaign($campaign)
            ->request(request());
        $this->prepareBookmarks();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->layout = $this->sidebar
            ->campaign($this->campaign)
            ->layout();

        return view('components.sidebar.campaign')
            ->with('layout', $this->layout);
    }

    public function active(string $menu = '', string $class = 'active'): ?string
    {
        if (empty($this->rules[$menu])) {
            return null;
        }

        if (request()->has('bookmark')) {
            return null;
        }

        foreach ($this->rules[$menu] as $rule) {
            if (request()->segment(3) == $rule) {
                return " {$class}";
            }
        }

        // Entities? It's complicated
        /** @var ?Entity $entity */
        $entity = request()->route('entity');
        if ($entity) {
            if ($entity->entityType->pluralCode() == $menu) {
                return " {$class}";
            }
        }

        return null;
    }

    /**
     * Prepare the quick links by figuring out where they will be rendered
     */
    public function prepareBookmarks(): void
    {
        $this->bookmarks = [];

        // Bookmarks module is not activated on the campaign, no need to go further
        if (! $this->campaign->enabled('bookmarks')) {
            return;
        }
        $bookmarks = $this->campaign->bookmarks()->active()->ordered()->with(['target' => function ($sub) {
            return $sub->select('id', 'type_id', 'entity_id');
        }, 'entityType', 'target.entityType'])->get();
        /** @var Bookmark $bookmark */
        foreach ($bookmarks as $bookmark) {
            if ($bookmark->entityType && $bookmark->entityType->isCustom() && ! $bookmark->entityType->isEnabled()) {
                continue;
            }
            $parent = 'bookmarks';
            if (! empty($bookmark->parent)) {
                $parent = $bookmark->parent;
            }
            $this->bookmarks[$parent][] = $bookmark;
        }
    }

    /**
     * Get the quick links for a specified section/parent
     */
    public function bookmarks(?string $parent = null): array
    {
        if (! $this->hasBookmarks($parent)) {
            return [];
        }

        return $this->bookmarks[$parent];
    }

    /**
     * Determine if a section has quick links in it
     */
    public function hasBookmarks(string $parent): bool
    {
        return array_key_exists($parent, $this->bookmarks) && ! empty($this->bookmarks[$parent]);
    }
}
