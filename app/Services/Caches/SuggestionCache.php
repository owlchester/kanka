<?php

namespace App\Services\Caches;

use App\Enums\EntityAssetType;
use App\Models\Bookmark;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\Entity;
use App\Models\EntityAsset;
use App\Models\EntityType;
use App\Models\Map;
use App\Models\MapMarker;
use App\Models\Quest;
use App\Models\QuestElement;
use App\Models\Scopes\AclScope;
use App\Models\Scopes\CampaignScope;
use App\Models\Timeline;
use App\Models\TimelineElement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SuggestionCache
{
    private const int TTL = 86400;

    /**
     * @return array<int, string>
     */
    public function entityTypes(Campaign|int $campaign, EntityType $entityType): array
    {
        $campaignId = $this->campaignId($campaign);

        return Cache::remember($this->entityTypesKey($campaignId, $entityType->code), self::TTL, function () use ($campaignId, $entityType) {
            return Entity::withoutGlobalScopes([CampaignScope::class, AclScope::class])
                ->where('campaign_id', $campaignId)
                ->where('type_id', $entityType->id)
                ->whereNotNull('type')
                ->select(DB::raw('type, MAX(created_at) as cmat'))
                ->groupBy('type')
                ->orderBy('cmat', 'desc')
                ->take(20)
                ->pluck('type')
                ->all();
        });
    }

    public function forgetEntityTypes(Campaign|int $campaign, EntityType $entityType): void
    {
        Cache::forget($this->entityTypesKey($this->campaignId($campaign), $entityType->code));
    }

    /**
     * @return array<int, string>
     */
    public function characterGenders(Campaign|int $campaign): array
    {
        $campaignId = $this->campaignId($campaign);

        return Cache::remember($this->characterGendersKey($campaignId), self::TTL, function () use ($campaignId) {
            return Character::withoutGlobalScopes([CampaignScope::class, AclScope::class])
                ->select(DB::raw('sex, MAX(e.created_at) as cmat'))
                ->join('entities as e', function ($join) {
                    $join->on('e.entity_id', '=', 'characters.id')
                        ->where('e.type_id', config('entities.ids.character'));
                })
                ->where('characters.campaign_id', $campaignId)
                ->whereNotNull('sex')
                ->groupBy('sex')
                ->orderBy('cmat', 'desc')
                ->take(10)
                ->pluck('sex')
                ->all();
        });
    }

    /**
     * @return array<int, string>
     */
    public function characterPronouns(Campaign|int $campaign): array
    {
        $campaignId = $this->campaignId($campaign);

        return Cache::remember($this->characterPronounsKey($campaignId), self::TTL, function () use ($campaignId) {
            return Character::withoutGlobalScopes([CampaignScope::class, AclScope::class])
                ->select(DB::raw('pronouns, MAX(e.created_at) as cmat'))
                ->join('entities as e', function ($join) {
                    $join->on('e.entity_id', '=', 'characters.id')
                        ->where('e.type_id', config('entities.ids.character'));
                })
                ->where('characters.campaign_id', $campaignId)
                ->whereNotNull('pronouns')
                ->groupBy('pronouns')
                ->orderBy('cmat', 'desc')
                ->take(10)
                ->pluck('pronouns')
                ->all();
        });
    }

    public function forgetCharacter(Campaign|int $campaign): void
    {
        $campaignId = $this->campaignId($campaign);

        Cache::forget($this->characterGendersKey($campaignId));
        Cache::forget($this->characterPronounsKey($campaignId));
    }

    /**
     * @return array<int, string>
     */
    public function questRoles(Campaign|int $campaign): array
    {
        $campaignId = $this->campaignId($campaign);

        return Cache::remember($this->questRolesKey($campaignId), self::TTL, function () use ($campaignId) {
            return QuestElement::join('quests as q', 'q.id', '=', 'quest_elements.quest_id')
                ->where('q.campaign_id', $campaignId)
                ->select(DB::raw('role, MAX(quest_elements.created_at) as cmat'))
                ->groupBy('role')
                ->whereNotNull('role')
                ->orderBy('cmat', 'desc')
                ->take(10)
                ->pluck('role')
                ->all();
        });
    }

    public function forgetQuestRoles(Campaign|int $campaign): void
    {
        Cache::forget($this->questRolesKey($this->campaignId($campaign)));
    }

    /**
     * @return array<int, string>
     */
    public function bookmarkIcons(Campaign|int $campaign): array
    {
        $campaignId = $this->campaignId($campaign);

        return Cache::remember($this->bookmarkIconsKey($campaignId), self::TTL, function () use ($campaignId) {
            return Bookmark::withoutGlobalScope(CampaignScope::class)
                ->where('campaign_id', $campaignId)
                ->whereNotNull('icon')
                ->select(DB::raw('icon, MAX(created_at) as cmat'))
                ->groupBy('icon')
                ->orderBy('cmat', 'desc')
                ->take(10)
                ->pluck('icon')
                ->all();
        });
    }

    public function forgetBookmarkIcons(Campaign|int $campaign): void
    {
        Cache::forget($this->bookmarkIconsKey($this->campaignId($campaign)));
    }

    /**
     * @return array<int, string>
     */
    public function entityAssetIcons(Campaign|int $campaign): array
    {
        $campaignId = $this->campaignId($campaign);

        return Cache::remember($this->entityAssetIconsKey($campaignId), self::TTL, function () use ($campaignId) {
            $default = [
                'fa-brands fa-d-and-d-beyond',
                'ra ra-aura',
            ];

            $icons = EntityAsset::leftJoin('entities as e', 'e.id', 'entity_assets.entity_id')
                ->where('e.campaign_id', $campaignId)
                ->select(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(metadata, "$.icon")) as icon, MAX(entity_assets.created_at) as cmat'))
                ->groupBy('metadata')
                ->whereNotNull('metadata->icon')
                ->where('entity_assets.type_id', EntityAssetType::link)
                ->orderBy('cmat', 'desc')
                ->take(10)
                ->pluck('icon')
                ->all();

            return array_slice(array_values(array_unique(array_merge($icons, $default))), 0, 10);
        });
    }

    public function forgetEntityAssetIcons(Campaign|int $campaign): void
    {
        Cache::forget($this->entityAssetIconsKey($this->campaignId($campaign)));
    }

    /**
     * @return array<int, string>
     */
    public function mapMarkerIcons(Campaign|int $campaign): array
    {
        $campaignId = $this->campaignId($campaign);

        return Cache::remember($this->mapMarkerIconsKey($campaignId), self::TTL, function () use ($campaignId) {
            $default = [
                'ra ra-tower',
                'fa-solid fa-home',
                'ra ra-capitol',
                'fa-solid fa-skull',
                'fa-solid fa-coins',
                'ra ra-beer',
                'fa-solid fa-map-marker-alt',
                'fa-solid fa-thumbtack',
                'ra ra-wooden-sign',
                'fa-solid fa-map-pin',
            ];

            $data = MapMarker::leftJoin('maps as m', 'm.id', 'map_markers.map_id')
                ->where('m.campaign_id', $campaignId)
                ->select(DB::raw('custom_icon, MAX(map_markers.created_at) as cmat'))
                ->groupBy('custom_icon')
                ->whereNotNull('custom_icon')
                ->orderBy('cmat', 'desc')
                ->take(10)
                ->pluck('custom_icon')
                ->all();

            return array_slice(array_values(array_unique(array_merge($data, $default))), 0, 10);
        });
    }

    public function forgetMapMarkerIcons(Campaign|int $campaign): void
    {
        Cache::forget($this->mapMarkerIconsKey($this->campaignId($campaign)));
    }

    /**
     * @return array<int, string>
     */
    public function timelineElementIcons(Campaign|int $campaign): array
    {
        $campaignId = $this->campaignId($campaign);

        return Cache::remember($this->timelineElementIconsKey($campaignId), self::TTL, function () use ($campaignId) {
            $default = [
                'ra ra-tower',
                'fa-solid fa-home',
                'ra ra-capitol',
                'fa-solid fa-skull',
                'fa-regular fa-coins',
                'ra ra-beer',
                'fa-solid fa-map-marker-alt',
                'fa-solid fa-thumbtack',
                'ra ra-wooden-sign',
                'fa-solid fa-map-pin',
            ];

            $data = TimelineElement::leftJoin('timelines as t', 't.id', 'timeline_elements.timeline_id')
                ->where('t.campaign_id', $campaignId)
                ->select(DB::raw('icon, MAX(timeline_elements.created_at) as cmat'))
                ->groupBy('icon')
                ->whereNotNull('icon')
                ->orderBy('cmat', 'desc')
                ->take(10)
                ->pluck('icon')
                ->all();

            return array_slice(array_values(array_unique(array_merge($data, $default))), 0, 10);
        });
    }

    public function forgetTimelineElementIcons(Campaign|int $campaign): void
    {
        Cache::forget($this->timelineElementIconsKey($this->campaignId($campaign)));
    }

    public function forgetForModel(Model $model): void
    {
        if ($model instanceof Entity) {
            if ($model->campaign_id && $model->entityType) {
                $this->forgetEntityTypes($model->campaign_id, $model->entityType);
            }

            return;
        }

        if ($model instanceof Character && $model->campaign_id) {
            $this->forgetCharacter($model->campaign_id);

            return;
        }

        if ($model instanceof Bookmark && $model->campaign_id) {
            $this->forgetBookmarkIcons($model->campaign_id);

            return;
        }

        if ($model instanceof QuestElement) {
            $campaignId = $model->relationLoaded('quest')
                ? $model->quest?->campaign_id
                : Quest::withoutGlobalScopes([CampaignScope::class, AclScope::class])->whereKey($model->quest_id)->value('campaign_id');

            if ($campaignId) {
                $this->forgetQuestRoles((int) $campaignId);
            }

            return;
        }

        if ($model instanceof EntityAsset) {
            $campaignId = $model->relationLoaded('entity')
                ? $model->entity?->campaign_id
                : Entity::withoutGlobalScopes([CampaignScope::class, AclScope::class])->whereKey($model->entity_id)->value('campaign_id');

            if ($campaignId) {
                $this->forgetEntityAssetIcons((int) $campaignId);
            }

            return;
        }

        if ($model instanceof MapMarker) {
            $campaignId = $model->relationLoaded('map')
                ? $model->map?->campaign_id
                : Map::withoutGlobalScopes([CampaignScope::class, AclScope::class])->whereKey($model->map_id)->value('campaign_id');

            if ($campaignId) {
                $this->forgetMapMarkerIcons((int) $campaignId);
            }

            return;
        }

        if ($model instanceof TimelineElement) {
            $campaignId = $model->relationLoaded('timeline')
                ? $model->timeline?->campaign_id
                : Timeline::withoutGlobalScopes([CampaignScope::class, AclScope::class])->whereKey($model->timeline_id)->value('campaign_id');

            if ($campaignId) {
                $this->forgetTimelineElementIcons((int) $campaignId);
            }
        }
    }

    private function campaignId(Campaign|int $campaign): int
    {
        return $campaign instanceof Campaign ? $campaign->id : $campaign;
    }

    private function entityTypesKey(int $campaignId, string $type): string
    {
        return "campaign_{$campaignId}_{$type}_type_suggestions";
    }

    private function characterGendersKey(int $campaignId): string
    {
        return "campaign_{$campaignId}_character_gender_suggestions";
    }

    private function characterPronounsKey(int $campaignId): string
    {
        return "campaign_{$campaignId}_character_pronoun_suggestions";
    }

    private function questRolesKey(int $campaignId): string
    {
        return "campaign_{$campaignId}_quest_element_role_suggestions";
    }

    private function bookmarkIconsKey(int $campaignId): string
    {
        return "campaign_{$campaignId}_bookmark_suggestions";
    }

    private function entityAssetIconsKey(int $campaignId): string
    {
        return "campaign_{$campaignId}_entity_asset_suggestions";
    }

    private function mapMarkerIconsKey(int $campaignId): string
    {
        return "campaign_{$campaignId}_map_marker_suggestions";
    }

    private function timelineElementIconsKey(int $campaignId): string
    {
        return "campaign_{$campaignId}_timeline_element_suggestions";
    }
}
