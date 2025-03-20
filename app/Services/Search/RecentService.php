<?php

namespace App\Services\Search;

use App\Facades\Avatar;
use App\Facades\Breadcrumb;
use App\Models\Bookmark;
use App\Models\Entity;
use App\Services\EntityTypeService;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Support\Collection;

/**
 * Builds a list of recent entities for the search + the list of bookmarks and entity types
 */
class RecentService
{
    use CampaignAware;
    use UserAware;

    public function __construct(
        protected EntityTypeService $entityTypeService
    ) {}

    public function recent(): array
    {
        $recentIds = $this->recentEntityIds();
        if (empty($recentIds)) {
            return [];
        }

        $orderedIds = implode(',', $recentIds);
        $entities = Entity::whereIn('id', $recentIds)
            ->with(['image', 'entityType'])
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
     * Todo: switch to a trait and share with SearchService
     */
    protected function formatForLookup(Entity $entity): array
    {
        return [
            'id' => $entity->id,
            'name' => $entity->name,
            'is_private' => $entity->is_private,
            'image' => Avatar::entity($entity)->fallback()->size(64)->thumbnail(),
            'link' => $entity->url(),
            'type' => $entity->entityType->name(),
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
        if (! cache()->has($key)) {
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
        $links = Bookmark::active()->with(['entity', 'dashboard', 'target', 'entityType'])->ordered()->get();
        /** @var Bookmark $link */
        foreach ($links as $link) {
            if (! $link->valid($this->campaign)) {
                continue;
            }
            $bookmarks[] = $this->formatBookmark($link);
        }

        return $bookmarks;
    }

    /**
     * Extract usable data from the bookmark
     */
    protected function formatBookmark(Bookmark $link): array
    {
        return [
            'url' => $link->getRoute(),
            'icon' => $link->iconClass(),
            'text' => $link->name,
        ];
    }

    public function indexes(): array
    {
        $types = $this->orderedTypes();
        $indexes = [];
        foreach ($types as $entityType) {
            $indexes[] = [
                'name' => $entityType->plural(),
                'icon' => $entityType->icon(),
                'url' => Breadcrumb::entityType($entityType)->index(),
            ];
        }

        return $indexes;
    }

    protected function orderedTypes(): Collection
    {
        return $this->entityTypeService
            ->campaign($this->campaign)
            ->exclude(config('entities.ids.bookmark'))
            ->ordered();
    }
}
