<?php

namespace App\Services\Campaign;

use App\Models\Attribute;
use App\Models\Bookmark;
use App\Models\EntityAbility;
use App\Models\Inventory;
use App\Models\Post;
use App\Models\Reminder;
use App\Traits\CampaignAware;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class StatService
{
    use CampaignAware;

    protected array $stats;

    public function get(): array
    {
        $key = 'campaign_stats_' . $this->campaign->id;
        if (Cache::has($key) && ! config('app.debug')) {
            return Cache::get($key);
        }

        $this->stats = [];

        // @phpstan-ignore-next-line
        $this->stats['entities'] = $this->campaign->entities()->withInvisible()->count();
        $this->permissions()
            ->types()
            ->modules();

        Cache::put($key, $this->stats, 3600 * 6);

        return $this->stats;
    }

    protected function types(): self
    {
        $stats = [];
        // @phpstan-ignore-next-line
        $res = $this->campaign
            ->entities()
            ->withInvisible()
            ->select(['type_id', DB::raw('count(*) as total')])
            ->groupBy('type_id')
            ->get();
        foreach ($res as $data) {
            $stats[$data->type_id] = $data->total;
        }
        arsort($stats);
        $this->stats['types'] = $stats;

        return $this;
    }

    protected function permissions(): self
    {
        $this->stats['permissions'] = [];
        $this->stats['permissions']['users'] = $this->campaign->users()->count();
        $this->stats['permissions']['followers'] = $this->campaign->followers()->count();
        $this->stats['permissions']['roles'] = $this->campaign->roles()->count();
        arsort($this->stats['permissions']);

        return $this;
    }

    protected function modules(): self
    {
        $this->stats['modules'] = [];
        // @phpstan-ignore-next-line
        $this->stats['modules']['entity_attributes'] = Attribute::withPrivate()->leftJoin('entities', 'entities.id', 'attributes.entity_id')->where('entities.campaign_id', $this->campaign->id)->count();
        // @phpstan-ignore-next-line
        $this->stats['modules']['posts'] = Post::withInvisible()->leftJoin('entities', 'entities.id', 'posts.entity_id')->where('entities.campaign_id', $this->campaign->id)->count();
        // @phpstan-ignore-next-line
        $this->stats['modules']['abilities'] = EntityAbility::withPrivate()->leftJoin('entities', 'entities.id', 'entity_abilities.entity_id')->where('entities.campaign_id', $this->campaign->id)->count();
        // @phpstan-ignore-next-line
        $this->stats['modules']['reminders'] = Reminder::withPrivate()->whereHas('remindable', function ($query) {
            $query->where('campaign_id', $this->campaign->id);
        })->count();
        // @phpstan-ignore-next-line
        $this->stats['modules']['inventories'] = Inventory::withPrivate()->leftJoin('entities', 'entities.id', 'inventories.entity_id')->where('entities.campaign_id', $this->campaign->id)->count();
        // @phpstan-ignore-next-line
        $this->stats['modules']['bookmarks'] = Bookmark::withPrivate()->where('campaign_id', $this->campaign->id)->count();
        arsort($this->stats['modules']);

        return $this;
    }
}
