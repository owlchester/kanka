<?php

namespace App\Services\Campaign;

use App\Models\Attribute;
use App\Models\Bookmark;
use App\Models\CharacterTrait;
use App\Models\Entity;
use App\Models\EntityAbility;
use App\Models\Inventory;
use App\Models\MapLayer;
use App\Models\MapMarker;
use App\Models\Post;
use App\Models\QuestElement;
use App\Models\Reminder;
use App\Models\TimelineElement;
use App\Models\TimelineEra;
use App\Traits\CampaignAware;
use Illuminate\Database\Eloquent\Builder;
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
            ->modules()
            ->words();

        Cache::put($key, $this->stats, 3600 * 24);

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
        $this->stats['modules']['reminders'] = Reminder::withPrivate()->whereHasMorph(
            'remindable',
            [Entity::class, Post::class],
            function (Builder $query, string $type) {
                if ($type === Entity::class) {
                    $query->where('campaign_id', $this->campaign->id);
                } else {
                    $query->leftJoin('entities as e', 'e.id', '=', 'posts.entity_id')
                        ->where('e.campaign_id', $this->campaign->id);
                }
            })->count();
        // @phpstan-ignore-next-line
        $this->stats['modules']['inventories'] = Inventory::withPrivate()->leftJoin('entities', 'entities.id', 'inventories.entity_id')->where('entities.campaign_id', $this->campaign->id)->count();
        // @phpstan-ignore-next-line
        $this->stats['modules']['bookmarks'] = Bookmark::withPrivate()->where('campaign_id', $this->campaign->id)->count();
        arsort($this->stats['modules']);

        return $this;
    }

    protected function words(): self
    {
        $this->stats['words'] = [
            'total' => 0,
            'entities' => 0,
            'posts' => 0,
        ];

        // Count the `words` field in the entities
        $entityWords = $this->campaign
            ->entities()
            ->withInvisible()
            ->sum('words');
        $this->stats['words']['entities'] = $entityWords;
        $this->stats['words']['total'] += $entityWords;

        // Count words from all posts of entities in the campaign
        $postWords = Post::withInvisible()
            ->leftJoin('entities', 'entities.id', 'posts.entity_id')
            ->where('entities.campaign_id', $this->campaign->id)
            ->sum('posts.words');
        $this->stats['words']['total'] += $postWords;
        $this->stats['words']['posts'] = $postWords;

        // Count words from all quest and timeline elements in the campaign
        $questWords = QuestElement::withPrivate()
            ->leftJoin('quests', 'quests.id', 'quest_elements.quest_id')
            ->where('quests.campaign_id', $this->campaign->id)
            ->sum('quest_elements.words');
        $this->stats['words']['total'] += $questWords;
        $this->stats['words']['elements'] = $questWords;
        $timelineWords = TimelineElement::withPrivate()
            ->leftJoin('timelines', 'timelines.id', 'timeline_elements.timeline_id')
            ->where('timelines.campaign_id', $this->campaign->id)
            ->sum('timeline_elements.words');
        $this->stats['words']['total'] += $timelineWords;
        $this->stats['words']['elements'] += $timelineWords;
        $timelineEraWords = TimelineEra::leftJoin('timelines', 'timelines.id', 'timeline_eras.timeline_id')
            ->where('timelines.campaign_id', $this->campaign->id)
            ->sum('timeline_eras.words');
        $this->stats['words']['total'] += $timelineEraWords;
        $this->stats['words']['elements'] += $timelineEraWords;

        // Map layers and markers
        $markerWords = MapMarker::leftJoin('maps', 'maps.id', 'map_markers.map_id')
            ->where('maps.campaign_id', $this->campaign->id)
            ->sum('map_markers.words');
        $this->stats['words']['total'] += $markerWords;
        $this->stats['words']['elements'] += $markerWords;
        $layerWords = MapLayer::leftJoin('maps', 'maps.id', 'map_layers.map_id')
            ->where('maps.campaign_id', $this->campaign->id)
            ->sum('map_layers.words');
        $this->stats['words']['total'] += $layerWords;
        $this->stats['words']['elements'] += $layerWords;

        // Character traits
        $traitWords = CharacterTrait::leftJoin('characters', 'characters.id', 'character_traits.character_id')
            ->where('characters.campaign_id', $this->campaign->id)
            ->sum('character_traits.words');
        $this->stats['words']['total'] += $traitWords;
        $this->stats['words']['elements'] += $traitWords;

        return $this;
    }
}
