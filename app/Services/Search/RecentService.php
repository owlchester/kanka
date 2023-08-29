<?php

namespace App\Services\Search;

use App\Facades\Avatar;
use App\Facades\Breadcrumb;
use App\Facades\Module;
use App\Models\Entity;
use App\Models\MenuLink;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Collator;
use Illuminate\Support\Str;

/**
 * Builds a list of recent entities for the search + the list of bookmarks and entity types
 */
class RecentService
{
    use CampaignAware;
    use UserAware;

    public function recent(): array
    {
        $recentIds = $this->recentEntityIds();
        if (empty($recentIds)) {
            return [];
        }

        $orderedIds = implode(',', $recentIds);
        $entities = Entity::whereIn('id', $recentIds)
            ->orderByRaw("FIELD(id, {$orderedIds})")
            ->get();
        $recent = [];

        /** @var Entity $entity */
        foreach ($entities as $entity) {
            $recent[] = $this->formatForLookup($entity);
        }

        return $recent;
    }

    /**
     * Format an entity for the lookup/search/recent dropdown
     * Todo: switch to train and share with SearchService
     */
    protected function formatForLookup(Entity $entity): array
    {
        return [
            'id' => $entity->id,
            'name' => $entity->name,
            'is_private' => $entity->is_private,
            'image' => Avatar::entity($entity)->size(64)->thumbnail(),
            'link' => $entity->url(),
            // @phpstan-ignore-next-line
            'type' => Module::singular($entity->typeId(), __('entities.' . $entity->type())),
            'preview' => route('entities.preview', [$this->campaign, $entity]),
        ];
    }


    public function logView(Entity $entity): void
    {
        $recents = $original = $this->recentEntityIds();
        $recents = array_diff($recents, [$entity->id]);
        $recents = [$entity->id, ...$recents];

        // Limit the array to five
        $recents = array_splice($recents, 0, 5);

        if ($recents == $original) {
            return;
        }
        $key = $this->recentEntityCacheKey();
        cache()->put($key, $recents, 7 * 86400);
    }

    protected function recentEntityIds(): array
    {
        $key = $this->recentEntityCacheKey();
        if (!cache()->has($key)) {
            return [];
        }
        return (array) cache()->get($key);
    }

    protected function recentEntityCacheKey(): string
    {
        return 'recent_c' . $this->campaign->id . '_u' . $this->user->id;
    }

    public function bookmarks(): array
    {
        $bookmarks = [];
        $links = MenuLink::active()->standardWith()->ordered()->get();
        /** @var MenuLink $link */
        foreach ($links as $link) {
            if (!$link->valid($this->campaign)) {
                continue;
            }
            $bookmarks[] = $this->formatBookmark($link);
        }

        return $bookmarks;
    }

    /**
     * Extract usable data from the bookmark
     */
    protected function formatBookmark(MenuLink $link): array
    {
        return [
            'url' => $link->getRoute(),
            'icon' => $link->icon(),
            'text' => $link->name,
        ];
    }

    public function indexes(): array
    {
        $types = $this->orderedTypes();
        $indexes = [];
        foreach ($types as $singular => $name) {
            $icon = Module::duoIcon($singular);
            $plural = Str::plural($singular);
            $indexes[] = [
                'name' => $name,
                'icon' => $icon,
                'url' => Breadcrumb::index($plural),
            ];
        }

        return $indexes;
    }

    protected function orderedTypes(): array
    {
        $types = config('entities.ids');
        unset($types['menu_link']);
        $orderedTypes = [];
        foreach ($types as $singular => $id) {
            $orderedTypes[$singular] = Module::singular($id, __('entities.' . $singular));
        }

        $collator = new Collator(app()->getLocale());
        $collator->asort($orderedTypes);

        return $orderedTypes;
    }
}
