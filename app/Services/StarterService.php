<?php

namespace App\Services;

use App\Enums\AttributeType;
use App\Enums\Widget;
use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Facades\CharacterCache;
use App\Facades\EntityCache;
use App\Facades\EntityPermission;
use App\Facades\UserCache;
use App\Models\Attribute;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use App\Models\CampaignEvent;
use App\Models\Character;
use App\Models\CharacterTrait;
use App\Models\Location;
use App\Models\Post;
use App\Models\Relation;
use App\Observers\CharacterObserver;
use App\Services\Campaign\CreateService;
use App\Traits\CampaignAware;
use App\Traits\UserAware;

class StarterService
{
    use CampaignAware;
    use UserAware;

    public function __construct(protected CreateService $createService) {}

    /**
     * Create a new campaign for the user when they register their account
     */
    public function create(): Campaign
    {
        $name = __('starter.campaign.name', ['user' => $this->user->name]);
        $request = [
            'name' => $name,
            'entry' => '',
            'excerpt' => '',
            'settings' => ['default-name' => $name],
        ];

        $this->campaign = $this->createService
            ->user($this->user)
            ->data($request)
            ->create();

        EntityPermission::campaign($this->campaign);
        CampaignCache::campaign($this->campaign);
        UserCache::campaign($this->campaign);

        $this->entities();
        $this->dashboard();

        CampaignEvent::create([
            'campaign_id' => $this->campaign->id,
            'created_by' => $this->user->id,
            'event' => 'campaign_created'
        ]);
        session()->put('onboarding', 1);

        return $this->campaign;
    }

    public function bind(): self
    {
        Character::observe(CharacterObserver::class);

        return $this;
    }

    public function entities()
    {
        CampaignLocalization::forceCampaign($this->campaign);
        request()->route()->setParameter('campaign', $this->campaign);
        EntityCache::campaign($this->campaign);
        CharacterCache::campaign($this->campaign);

        // Generate locations
        $kingdom = new Location([
            'name' => __('starter.kingdom.name'),
            'campaign_id' => $this->campaign->id,
            'is_private' => false,
        ]);
        $kingdom->save();
        $kingdom->entity->update([
            'type' => __('starter.kingdom.type'),
            'entry' => '<p>' . __('starter.kingdom.description') . '</p>',
            'source' => 'onboarding',
        ]);
        Post::create([
            'entity_id' => $kingdom->entity->id,
            'name' => __('starter.kingdom.recent.title'),
            'entry' => '<ol>' .
                '<li>' . __('starter.kingdom.recent.first') . '</li>' .
                '<li>' . __('starter.kingdom.recent.second') . '</li>' .
                '</ol>',
        ]);
        Attribute::create([
            'entity_id' => $kingdom->entity->id,
            'name' => __('starter.kingdom.features.pop.name'),
            'value' => __('starter.kingdom.features.pop.value'),
            'is_pinned' => true,
            'type_id' => AttributeType::Standard,
        ]);
        Attribute::create([
            'entity_id' => $kingdom->entity->id,
            'name' => __('starter.kingdom.features.exp.name'),
            'value' => __('starter.kingdom.features.exp.value'),
            'is_pinned' => true,
            'type_id' => AttributeType::Standard,
        ]);
        Attribute::create([
            'entity_id' => $kingdom->entity->id,
            'name' => __('starter.kingdom.features.gov.name'),
            'value' => __('starter.kingdom.features.gov.value'),
            'is_pinned' => true,
            'type_id' => AttributeType::Standard,
        ]);

        $city = new Location([
            'name' => __('starter.city.name'),
            'location_id' => $kingdom->id,
            'campaign_id' => $this->campaign->id,
            'is_private' => false,
        ]);
        $city->save();
        $city->entity->update([
            'source' => 'onboarding',
            'type' => __('starter.city.type'),
            'entry' => '<p>' . __('starter.city.description') . '</p>',
        ]);

        Post::create([
            'entity_id' => $city->entity->id,
            'name' => __('starter.city.districts.title'),
            'entry' => '<ol>' .
                '<li>' . __('starter.city.districts.first') . '</li>' .
                '<li>' . __('starter.city.districts.second') . '</li>' .
                '<li>' . __('starter.city.districts.third') . '</li>' .
                '<li>' . __('starter.city.districts.fourth') . '</li>' .
                '</ol>',
        ]);
        Post::create([
            'entity_id' => $city->entity->id,
            'name' => __('starter.city.locations.title'),
            'entry' => '<ol>' .
                '<li>' . __('starter.city.locations.first') . '</li>' .
                '<li>' . __('starter.city.locations.second') . '</li>' .
                '<li>' . __('starter.city.locations.third') . '</li>' .
                '</ol>',
        ]);


        Attribute::create([
            'entity_id' => $kingdom->entity->id,
            'name' => __('starter.kingdom.features.capital.name'),
            'value' => '[entity:' . $city->entity->id . ']',
            'is_pinned' => true,
            'type_id' => AttributeType::Standard,
        ]);

        // Generate characters
        $james = new Character([
            'name' => __('starter.character1.name'),
            'age' => __('starter.character1.age'),
            'campaign_id' => $this->campaign->id,
            'is_private' => false,
            'is_appearance_pinned' => true,
            'is_personality_pinned' => true,
        ]);
        $james->save();
        $james->entity->locations()->sync([$city->id]);
        CharacterTrait::create([
            'character_id' => $james->id,
            'name' => __('starter.character1.physical.build.name'),
            'entry' => __('starter.character1.physical.build.value'),
            'section_id' => CharacterTrait::SECTION_APPEARANCE,
        ]);
        CharacterTrait::create([
            'character_id' => $james->id,
            'name' => __('starter.character1.physical.features.name'),
            'entry' => __('starter.character1.physical.features.value'),
            'section_id' => CharacterTrait::SECTION_APPEARANCE,
        ]);
        CharacterTrait::create([
            'character_id' => $james->id,
            'name' => __('starter.character1.personality.trait1.name'),
            'entry' => __('starter.character1.personality.trait1.value'),
            'section_id' => CharacterTrait::SECTION_PERSONALITY,
        ]);
        CharacterTrait::create([
            'character_id' => $james->id,
            'name' => __('starter.character1.personality.trait2.name'),
            'entry' => __('starter.character1.personality.trait2.value'),
            'section_id' => CharacterTrait::SECTION_PERSONALITY,
        ]);
        CharacterTrait::create([
            'character_id' => $james->id,
            'name' => __('starter.character1.personality.trait2.name'),
            'entry' => __('starter.character1.personality.trait2.value'),
            'section_id' => CharacterTrait::SECTION_PERSONALITY,
        ]);
        $james->entity->update([
            'source' => 'onboarding',
            'entry' =>
                '<p>' . __('starter.character1.description.template') . '</p>' .
                '<p>' . __('starter.character1.description.intro') . '</p>' .
                '<p>' . __('starter.character1.description.tip') . '</p>',
        ]);

        Post::create([
            'entity_id' => $james->entity->id,
            'name' => __('starter.character1.background.title'),
            'entry' => '<ol>' .
                '<li>' . __('starter.character1.background.loc') . '</li>' .
                '<li>' . __('starter.character1.background.cur') . '</li>' .
                '<li>' . __('starter.character1.background.seeking') . '</li>' .
            '</ol>',
        ]);


        $irwie = new Character([
            'name' => __('starter.character2.name'),
            'age' => __('starter.character1.age'),
            'campaign_id' => $this->campaign->id,
            'is_private' => false,
            'is_appearance_pinned' => true,
            'is_personality_pinned' => true,
        ]);
        $irwie->save();
        $irwie->entity->locations()->sync([$city->id]);
        $irwie->entity->update([
            'source' => 'onboarding',
            'entry' => '<p>' . __('starter.character2.description.first', ['mention' => '[entity:' . $james->entity->id . ']']) . '</p>' .
            '<p>' . __('starter.character2.description.second') . '</p>',
        ]);

        CharacterTrait::create([
            'character_id' => $irwie->id,
            'name' => __('starter.character1.physical.build.name'),
            'entry' => __('starter.character1.physical.build.value'),
            'section_id' => CharacterTrait::SECTION_APPEARANCE,
        ]);
        CharacterTrait::create([
            'character_id' => $irwie->id,
            'name' => __('starter.character1.physical.features.name'),
            'entry' => __('starter.character1.physical.features.value'),
            'section_id' => CharacterTrait::SECTION_APPEARANCE,
        ]);
        CharacterTrait::create([
            'character_id' => $irwie->id,
            'name' => __('starter.character1.personality.trait1.name'),
            'entry' => __('starter.character1.personality.trait1.value'),
            'section_id' => CharacterTrait::SECTION_PERSONALITY,
        ]);
        CharacterTrait::create([
            'character_id' => $irwie->id,
            'name' => __('starter.character1.personality.trait2.name'),
            'entry' => __('starter.character1.personality.trait2.value'),
            'section_id' => CharacterTrait::SECTION_PERSONALITY,
        ]);
        CharacterTrait::create([
            'character_id' => $irwie->id,
            'name' => __('starter.character1.personality.trait2.name'),
            'entry' => __('starter.character1.personality.trait2.value'),
            'section_id' => CharacterTrait::SECTION_PERSONALITY,
        ]);

        Post::create([
            'entity_id' => $irwie->entity->id,
            'name' => __('starter.character2.skills.title'),
            'entry' => '<ol>' .
                '<li>' . __('starter.character2.skills.first') . '</li>' .
                '<li>' . __('starter.character2.skills.second') . '</li>' .
                '<li>' . __('starter.character2.skills.third') . '</li>' .
                '</ol>',
        ]);

        Relation::create([
            'owner_id' => $irwie->entity->id,
            'target_id' => $james->entity->id,
            'relation' => __('starter.character2.relation'),
            'campaign_id' => $this->campaign->id,
        ]);
    }

    /**
     * Setup the new campaign's dashboard
     */
    protected function dashboard()
    {
        $position = 0;

        // Recent widget
        $widget = new CampaignDashboardWidget([
            'campaign_id' => $this->campaign->id,
            'widget' => Widget::Recent,
            'width' => 4,
            'position' => $position++,
        ]);
        $widget->save();

        $widget = new CampaignDashboardWidget([
            'campaign_id' => $this->campaign->id,
            'widget' => Widget::Onboarding,
            'width' => 4,
            'position' => $position++,
        ]);
        $widget->save();

        $widget = new CampaignDashboardWidget([
            'campaign_id' => $this->campaign->id,
            'widget' => Widget::Help,
            'width' => 4,
            'position' => $position++,
        ]);
        $widget->save();
    }
}
