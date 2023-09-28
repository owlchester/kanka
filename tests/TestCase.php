<?php

namespace Tests;

use App\Facades\CampaignCache;
use App\Facades\EntityCache;
use App\Facades\Permissions;
use App\Facades\UserCache;
use App\Models\Ability;
use App\Models\Attribute;
use App\Models\Bookmark;
use App\Models\Campaign;
use App\Models\CampaignRoleUser;
use App\Models\CampaignUser;
use App\Models\Creature;
use App\Models\Character;
use App\Models\Calendar;
use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Models\ConversationMessage;
use App\Models\Family;
use App\Models\Location;
use App\Models\Map;
use App\Models\MapLayer;
use App\Models\MapMarker;
use App\Models\MapGroup;
use App\Models\Organisation;
use App\Models\Item;
use App\Models\Note;
use App\Models\Event;
use App\Models\EntityAsset;
use App\Models\EntityEvent;
use App\Models\Race;
use App\Models\Quest;
use App\Models\QuestElement;
use App\Models\Journal;
use App\Models\Tag;
use App\Models\Timeline;
use App\Models\TimelineEra;
use App\Models\TimelineElement;
use App\Models\DiceRoll;
use App\Facades\CampaignLocalization;
use App\Facades\CharacterCache;
use App\Facades\QuestCache;
use App\Facades\TimelineElementCache;
use App\Models\Post;
use App\Facades\MapMarkerCache;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected bool $isPlayer = false;

    protected function setUp(): void
    {
        parent::setUp();
        //putenv(LaravelLocalization::ENV_ROUTE_KEY . '=' . 'en');
    }

    public function asUser(): self
    {
        Passport::actingAs(
            \App\User::factory()->create(),
            ['*']
        );
        return $this;
    }

    public function asPlayer(): self
    {
        $user2 =  \App\User::factory()->create();
        Passport::actingAs(
            $user2,
            ['*']
        );

        $this->isPlayer = true;
        CampaignUser::create([
            'campaign_id' => 1,
            'user_id' => $user2->id,
        ]);

        CampaignRoleUser::create([
            'campaign_role_id' => 3,
            'user_id' => $user2->id,
        ]);

        Permissions::reset();

        return $this;
    }

    public function withCampaign(array $extra = []): self
    {
        $campaign = Campaign::factory()->create($extra);
        CampaignLocalization::forceCampaign($campaign);

        EntityCache::campaign($campaign);
        CampaignCache::campaign($campaign);
        UserCache::campaign($campaign);
        QuestCache::campaign($campaign);
        TimelineElementCache::campaign($campaign);
        CharacterCache::campaign($campaign);
        MapMarkerCache::campaign($campaign);

        return $this;
    }

    public function withCreatures(array $extra = []): self
    {
        Creature::factory()
            ->count(5)
            ->create(['campaign_id' => 1] + $extra);
        return $this;
    }

    public function withCharacters(array $extra = []): self
    {
        Character::factory()
            ->count(5)
            ->create(['campaign_id' => 1] + $extra);
        return $this;
    }

    public function withFamilies(array $extra = []): self
    {
        Family::factory()
            ->count(5)
            ->create(['campaign_id' => 1] + $extra);
        return $this;
    }

    public function withLocations(array $extra = []): self
    {
        Location::factory()
            ->count(5)
            ->create(['campaign_id' => 1] + $extra);
        return $this;
    }

    public function withOrganisations(array $extra = []): self
    {
        Organisation::factory()
            ->count(5)
            ->create(['campaign_id' => 1] + $extra);
        return $this;
    }

    public function withItems(array $extra = []): self
    {
        Item::factory()
            ->count(5)
            ->create(['campaign_id' => 1] + $extra);
        return $this;
    }

    public function withNotes(array $extra = []): self
    {
        Note::factory()
            ->count(5)
            ->create(['campaign_id' => 1] + $extra);
        return $this;
    }

    public function withEvents(array $extra = []): self
    {
        Event::factory()
            ->count(5)
            ->create(['campaign_id' => 1] + $extra);
        return $this;
    }

    public function withCalendars(array $extra = []): self
    {
        Calendar::factory()
            ->count(5)
            ->create(['campaign_id' => 1] + $extra);
        return $this;
    }

    public function withRaces(array $extra = []): self
    {
        Race::factory()
            ->count(5)
            ->create(['campaign_id' => 1] + $extra);
        return $this;
    }

    public function withQuestElements(array $extra = []): self
    {
        QuestElement::factory()
            ->count(5)
            ->create(['quest_id' => 1] + $extra);
        return $this;
    }


    public function withQuests(array $extra = []): self
    {
        Quest::factory()
            ->count(5)
            ->create(['campaign_id' => 1] + $extra);
        return $this;
    }

    public function withJournals(array $extra = []): self
    {
        Journal::factory()
            ->count(5)
            ->create(['campaign_id' => 1] + $extra);
        return $this;
    }

    public function withTags(array $extra = []): self
    {
        Tag::factory()
            ->count(5)
            ->create(['campaign_id' => 1] + $extra);
        return $this;
    }

    public function withAbilities(array $extra = []): self
    {
        Ability::factory()
            ->count(5)
            ->create(['campaign_id' => 1] + $extra);
        return $this;
    }

    public function withTimelines(array $extra = []): self
    {
        Timeline::factory()
            ->count(5)
            ->create(['campaign_id' => 1] + $extra);
        return $this;
    }

    public function withTimelineEras(array $extra = []): self
    {
        TimelineEra::factory()
            ->count(5)
            ->create(['timeline_id' => 1] + $extra);
        return $this;
    }

    public function withTimelineElements(array $extra = []): self
    {
        TimelineElement::factory()
            ->count(5)
            ->create(['timeline_id' => 1, 'era_id' => 1] + $extra);
        return $this;
    }

    public function withDiceRolls(array $extra = []): self
    {
        DiceRoll::factory()
            ->count(5)
            ->create(['campaign_id' => 1] + $extra);
        return $this;
    }

    public function withConversations(array $extra = []): self
    {
        Conversation::factory()
            ->count(5)
            ->create(['campaign_id' => 1] + $extra);
        return $this;
    }

    public function withConversationParticipants(array $extra = []): self
    {
        ConversationParticipant::factory()
            ->count(5)
            ->create(['conversation_id' => 1] + $extra);
        return $this;
    }

    public function withConversationMessages(array $extra = []): self
    {
        ConversationMessage::factory()
            ->count(5)
            ->create(['conversation_id' => 1] + $extra);
        return $this;
    }

    public function withBookmarks(array $extra = []): self
    {
        Bookmark::factory()
            ->count(5)
            ->create(['campaign_id' => 1] + $extra);
        return $this;
    }

    public function withMaps(array $extra = []): self
    {
        Map::factory()
            ->count(5)
            ->create(['campaign_id' => 1] + $extra);
        return $this;
    }

    public function withMapLayers(array $extra = []): self
    {
        MapLayer::factory()
            ->count(5)
            ->create(['map_id' => 1] + $extra);
        return $this;
    }

    public function withMapGroups(array $extra = []): self
    {
        MapGroup::factory()
            ->count(5)
            ->create(['map_id' => 1] + $extra);
        return $this;
    }

    public function withMapMarkers(array $extra = []): self
    {
        MapMarker::factory()
            ->count(5)
            ->create(['map_id' => 1] + $extra);
        return $this;
    }

    public function withAttributes(array $extra = []): self
    {
        Attribute::factory()
            ->count(5)
            ->create(['entity_id' => 1, 'type_id' => 1, 'api_key' => 1] + $extra);
        return $this;
    }

    public function withAssets(array $extra = []): self
    {
        EntityAsset::factory()
            ->count(5)
            ->create(['entity_id' => 1, 'type_id' => 3] + $extra);
        return $this;
    }

    public function withEntityEvents(array $extra = []): self
    {
        EntityEvent::factory()
            ->count(5)
            ->create(['entity_id' => 1] + $extra);
        return $this;
    }

    public function withPosts(array $extra = []): self
    {
        Post::factory()
            ->count(5)
            ->create(['entity_id' => 1] + $extra);
        return $this;
    }
}
