<?php

namespace Tests;

use App\Facades\Avatar;
use App\Facades\CampaignCache;
use App\Facades\EntityCache;
use App\Facades\Permissions;
use App\Facades\UserCache;
use App\Models\Ability;
use App\Models\CampaignDashboardWidget;
use App\Models\CampaignRole;
use App\Models\Attribute;
use App\Models\Bookmark;
use App\Models\Campaign;
use App\Services\Permissions\RolePermissionService;
use Illuminate\Support\Facades\Storage;
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
use App\Models\Relation;
use App\Models\EntityTag;
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
use App\Facades\Mentions;
use App\Models\CampaignStyle;
use App\Models\Image;
use Laravel\Passport\Passport;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Carbon\Carbon;
use Laravel\Cashier\Subscription;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected bool $isPlayer = false;

    protected function setUp(): void
    {
        parent::setUp();
        //putenv(LaravelLocalization::ENV_ROUTE_KEY . '=' . 'en');

        //putenv(LaravelLocalization::ENV_ROUTE_KEY . '=' . 'en');
    }

    public function asUser(bool $subscribed = false): self
    {
        $user = \App\Models\User::factory()->create();
        Passport::actingAs(
            $user,
            ['*']
        );
        if ($subscribed) {
            // Add the subscriber role
            $user->roles()->syncWithoutDetaching([5]);

            // Add the subscription to the user level
            $user->pledge = 'Elemental';
            $user->save();

            $sub = new Subscription();
            $sub->user_id = $user->id;
            $sub->type = 'kanka';
            $sub->stripe_id = 'manual_sub_' . uniqid();
            $sub->stripe_status = 'canceled';
            $sub->stripe_price = 'paypal_' . $user->pledge;
            $sub->quantity = 1;
            $sub->ends_at = Carbon::now()->addYear();
            $sub->save();
        }
        return $this;
    }

    public function asPlayer(): self
    {
        $user2 =  \App\Models\User::factory()->create();
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
        /** @var RolePermissionService $service */
        $service = app()->make(RolePermissionService::class);
        $service->role(CampaignRole::where('id', 3)->first())->toggle(1, 1);
        $service->role(CampaignRole::where('id', 3)->first())->toggle(10, 1);
        $service->role(CampaignRole::where('id', 3)->first())->toggle(11, 1);
        $service->role(CampaignRole::where('id', 3)->first())->toggle(7, 1);

        return $this;
    }

    public function withMember(): self
    {
        $user3 =  \App\Models\User::factory()->create();

        CampaignUser::create([
            'campaign_id' => 1,
            'user_id' => $user3->id,
        ]);

        CampaignRoleUser::create([
            'campaign_role_id' => 3,
            'user_id' => $user3->id,
        ]);

        /** @var RolePermissionService $service */
        $service = app()->make(RolePermissionService::class);
        $service->role(CampaignRole::where('id', 3)->first())->toggle(1, 1);

        return $this;
    }

    public function withCampaign(array $extra = []): self
    {
        $this->seed(\Database\Seeders\VisibilitiesTableSeeder::class);
        $this->seed(\Database\Seeders\EntityTypesTableSeeder::class);
        Storage::fake('s3');

        $campaign = Campaign::factory()->create($extra);
        CampaignLocalization::forceCampaign($campaign);

        EntityCache::campaign($campaign);
        CampaignCache::campaign($campaign);
        UserCache::campaign($campaign);
        Mentions::campaign($campaign);
        QuestCache::campaign($campaign);
        TimelineElementCache::campaign($campaign);
        CharacterCache::campaign($campaign);
        MapMarkerCache::campaign($campaign);
        Avatar::campaign($campaign);

        return $this;
    }

    public function withCampaigns(array $extra = []): self
    {
        Campaign::factory()->create($extra);
        return $this;
    }

    public function withPermissions(array $extra = []): self
    {
        /** @var RolePermissionService $service */
        $service = app()->make(RolePermissionService::class);
        $service->role(CampaignRole::where('id', 3)->first())->toggle(1, 1);
        $service->role(CampaignRole::where('id', 3)->first())->toggle(1, 2);
        $service->role(CampaignRole::where('id', 3)->first())->toggle(1, 3);

        return $this;
    }

    public function withCampaignStyles(array $extra = []): self
    {
        CampaignStyle::factory()
            ->count(5)
            ->create(['campaign_id' => 1] + $extra);
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
            ->create(['entity_id' => 1, 'is_template' => false] + $extra);
        return $this;
    }

    public function withRelations(array $extra = []): self
    {
        Relation::factory()
            ->count(5)
            ->create(['owner_id' => 1, 'target_id' => 2, 'campaign_id' => 1] + $extra);
        return $this;
    }

    public function withEntityTags(array $extra = []): self
    {
        EntityTag::factory()
            ->count(5)
            ->create($extra);
        return $this;
    }

    public function withDashboardWidgets(array $extra = []): self
    {
        CampaignDashboardWidget::factory()
            ->count(5)
            ->create(['campaign_id' => 1]);
        return $this;
    }

    public function withImages(array $extra = []): self
    {
        Image::factory()
            ->count(1)
            ->create(['campaign_id' => 1] + $extra);
        return $this;
    }

    public function withThumbnails(array $extra = []): self
    {
        Image::factory()
            ->count(1)
            ->create(['campaign_id' => 1] + $extra);
        return $this;
    }

    public function withCharacterTags(array $extra = []): self
    {
        Character::factory()
            ->count(1)
            ->create(['campaign_id' => 1]);

        Tag::factory()
            ->count(3)
            ->create(['campaign_id' => 1] + $extra);

        EntityTag::factory()->count(2)->state(
            new Sequence(
                ['tag_id' => 1, 'entity_id' => 1],
                ['tag_id' => 2, 'entity_id' => 1],
            )
        )->create();

        return $this;
    }

    public function withPrivateCharacterTags(array $extra = []): self
    {
        Character::factory()
            ->count(1)
            ->create(['campaign_id' => 1, 'is_private' => false]);

        Tag::factory()
            ->count(2)
            ->state(
                new Sequence(
                    ['campaign_id' => 1],
                    ['campaign_id' => 1, 'is_private' => true]
                )
            )
            ->create();

        EntityTag::factory()->count(2)->state(
            new Sequence(
                ['tag_id' => 1, 'entity_id' => 1],
                ['tag_id' => 2, 'entity_id' => 1],
            )
        )->create();

        return $this;
    }
}
