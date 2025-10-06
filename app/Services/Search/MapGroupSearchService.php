<?php

namespace App\Services\Search;

use App\Models\Map;
use App\Models\MapGroup;
use App\Traits\CampaignAware;
use App\Traits\RequestAware;
use App\Traits\Search\Orderable;
use Illuminate\Database\Eloquent\Builder;

class MapGroupSearchService
{
    use CampaignAware;
    use Orderable;
    use RequestAware;

    protected Builder $query;

    public Map $map;

    public function map(Map $map): self
    {
        $this->map = $map;

        return $this;
    }

    public function search(): array
    {
        $term = mb_trim($this->request->get('q') ?? '');
        $excludes = $this->request->has('exclude') ? $this->request->get('exclude') : null;

        $this->query = MapGroup::where('map_id', $this->map->id);
        if (! empty($excludes)) {
            $this->query->whereNotIn('id', [$excludes]);
        }

        $this->order($term);
        $groups = $this->query
            ->limit(10)
            ->get();

        $list = [];
        /** @var MapGroup $group */
        foreach ($groups as $group) {
            $format = [
                'id' => $group->id,
                'name' => $group->name,
                'text' => $group->name,
            ];

            $list[] = $format;
        }

        return $list;
    }
}
