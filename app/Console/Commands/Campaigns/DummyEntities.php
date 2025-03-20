<?php

namespace App\Console\Commands\Campaigns;

use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Facades\CharacterCache;
use App\Facades\EntityCache;
use App\Facades\QuestCache;
use App\Models\Ability;
use App\Models\Attribute;
use App\Models\Calendar;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\EntityAbility;
use App\Models\Event;
use App\Models\Family;
use App\Models\Item;
use App\Models\Journal;
use App\Models\Location;
use App\Models\Note;
use App\Models\Organisation;
use App\Models\Quest;
use App\Models\QuestElement;
use App\Models\Race;
use App\Models\Relation;
use App\Models\Tag;
use App\Observers\AbilityObserver;
use App\Observers\CalendarObserver;
use App\Observers\CharacterObserver;
use App\Observers\EntityAbilityObserver;
use App\Observers\EventObserver;
use App\Observers\FamilyObserver;
use App\Observers\ItemObserver;
use App\Observers\JournalObserver;
use App\Observers\LocationObserver;
use App\Observers\NoteObserver;
use App\Observers\OrganisationObserver;
use App\Observers\QuestElementObserver;
use App\Observers\QuestObserver;
use App\Observers\RaceObserver;
use App\Observers\RelationObserver;
use App\Observers\TagObserver;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Factories\Sequence;

class DummyEntities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaigns:populate {campaign}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate dummy entities in a specified campaign';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $campaignId = (int) $this->argument('campaign');
        $campaign = Campaign::findOrFail($campaignId);

        CampaignCache::campaign($campaign);
        EntityCache::campaign($campaign);
        CharacterCache::campaign($campaign);
        QuestCache::campaign($campaign);

        $this->loadObservers($campaign);

        //Generate Characters Abilities and Locations
        $firstLocation = Location::factory()
            ->state(['name' => 'Thaelia', 'campaign_id' => $campaign->id])
            ->has(
                Character::factory()->state(['campaign_id' => $campaign->id])
                    ->has(Item::factory()->state(['name' => 'Sword of Cebolla', 'campaign_id' => $campaign->id, 'price' => rand(1, 15) . 'g']))
            )
            ->has(Location::factory()
                ->state(['name' => 'March', 'campaign_id' => $campaign->id])
                ->has(Location::factory()
                    ->state(['name' => 'Adestry', 'campaign_id' => $campaign->id])))
            ->has(Location::factory()
                ->state(['name' => 'Tilley', 'campaign_id' => $campaign->id])
                ->has(Location::factory()
                    ->state(['name' => 'Carrothead', 'campaign_id' => $campaign->id])))
            ->has(Character::factory()->state(['campaign_id' => $campaign->id])->count(2))
            ->has(Location::factory()->state(['name' => 'Orlene', 'campaign_id' => $campaign->id]))
            ->has(Location::factory()
                ->state(['name' => 'Owlchester', 'campaign_id' => $campaign->id]))
            ->create();

        $secondLocation = Location::factory()
            ->state(['name' => 'Medina', 'campaign_id' => $campaign->id])
            ->has(Location::factory()->count(2)->state(new Sequence(
                ['name' => 'Torchio', 'campaign_id' => $campaign->id],
                ['name' => 'Urdino', 'campaign_id' => $campaign->id]
            )))
            ->has(Character::factory()->state(['campaign_id' => $campaign->id]))
            ->has(Character::factory()->state(['campaign_id' => $campaign->id])
                ->has(Item::factory()->state(['name' => 'Dagger of Longaniza', 'campaign_id' => $campaign->id, 'price' => rand(1, 15) . 'g'])))
            ->create();
        $thirdLocation = Location::factory()->state(['campaign_id' => $campaign->id, 'name' => 'Middle Earth'])->create();

        //Generate Characters
        $firstCharacter = Character::factory()->state(['campaign_id' => $campaign->id, 'name' => 'Biblo Swaggins'])->create();
        $secondCharacter = Character::factory()->state(['campaign_id' => $campaign->id])->create();
        $thirdCharacter = Character::factory()->state(['campaign_id' => $campaign->id])->create();
        $fourthCharacter = Character::factory()->state(['campaign_id' => $campaign->id])->create();
        $fifthCharacter = Character::factory()->state(['campaign_id' => $campaign->id])->create();

        Ability::factory()->state(['name' => 'Loud shout', 'campaign_id' => $campaign->id])->has(EntityAbility::factory()->state(['entity_id' => $firstCharacter->entity->id]), 'ability')->create();
        Attribute::factory()->count(7)->state(
            new Sequence(
                ['name' => 'Population', 'entity_id' => $firstLocation->entity->id, 'is_pinned' => 1],
                ['name' => 'Population', 'entity_id' => $secondLocation->entity->id, 'is_pinned' => 1],
                ['name' => 'Population', 'entity_id' => $thirdLocation->entity->id, 'is_pinned' => 1],
                ['name' => 'HP', 'value' => rand(1, 20), 'entity_id' => $firstCharacter->entity->id, 'is_pinned' => 1],
                ['name' => 'Level', 'value' => rand(1, 20), 'entity_id' => $firstCharacter->entity->id, 'is_pinned' => 1],
                ['name' => 'HP', 'value' => rand(1, 20), 'entity_id' => $secondCharacter->entity->id, 'is_pinned' => 1],
                ['name' => 'Level', 'value' => rand(1, 20), 'entity_id' => $secondCharacter->entity->id, 'is_pinned' => 1],
            )
        )
            ->create();

        //Generate Families
        Family::factory()
            ->state(['name' => 'Graff', 'campaign_id' => $campaign->id])
            ->has(Family::factory()->state(['name' => 'Market', 'campaign_id' => $campaign->id]))
            ->create();
        Family::factory()->state(['name' => 'Joren', 'campaign_id' => $campaign->id])->create();

        //Generate Organisations
        Organisation::factory()
            ->state(['name' => 'Kankappy Cult', 'campaign_id' => $campaign->id])
            ->has(Organisation::factory()->state(['name' => 'Fun Police', 'campaign_id' => $campaign->id]))
            ->create();
        Organisation::factory()->state(['name' => 'Great Reset', 'campaign_id' => $campaign->id])->create();

        //Generate Events
        Event::factory()->count(4)->state(
            new Sequence(
                ['name' => 'The Great War', 'campaign_id' => $campaign->id],
                ['name' => 'Northern Rebellion', 'campaign_id' => $campaign->id],
                ['name' => 'Peace of the Sea', 'campaign_id' => $campaign->id],
                ['name' => 'Royal Wedding', 'campaign_id' => $campaign->id],
            )
        )
            ->create();

        //Generate Items
        Item::factory()->count(5)->state(
            new Sequence(
                ['name' => 'Bow', 'campaign_id' => $campaign->id],
                ['name' => 'Crowbar', 'campaign_id' => $campaign->id],
                ['name' => 'Shield', 'campaign_id' => $campaign->id],
                ['name' => 'Sword', 'campaign_id' => $campaign->id],
                ['name' => 'Potion', 'campaign_id' => $campaign->id],
            )
        )
            ->create();

        //Generate Notes
        Note::factory()->count(3)->state(
            new Sequence(
                ['name' => 'Aromas of Geneva', 'campaign_id' => $campaign->id],
                ['name' => 'Pottery Stacking', 'campaign_id' => $campaign->id],
                ['name' => 'Making Friends', 'campaign_id' => $campaign->id],
            )
        )
            ->create();

        //Generate Races
        Race::factory()
            ->state(['name' => 'Elf', 'campaign_id' => $campaign->id])
            ->has(Race::factory()
                ->state(['name' => 'Wood elf', 'campaign_id' => $campaign->id])
                ->has(Race::factory()
                    ->state(['name' => 'Leaf elf', 'campaign_id' => $campaign->id])))
            ->has(Race::factory()->state(['name' => 'High elf', 'campaign_id' => $campaign->id]))
            ->create();

        Race::factory()->count(2)->state(
            new Sequence(
                ['name' => 'Human', 'campaign_id' => $campaign->id],
                ['name' => 'Owlbear', 'campaign_id' => $campaign->id],
            )
        )
            ->create();

        //Generate Tags
        Tag::factory()->count(3)->state(
            new Sequence(
                ['name' => '🧛🏻‍♂️', 'colour' => 'maroon', 'campaign_id' => $campaign->id],
                ['name' => 'Important', 'colour' => 'aqua', 'campaign_id' => $campaign->id],
                ['name' => 'NPC', 'colour' => 'grey', 'campaign_id' => $campaign->id],
            )
        )
            ->create();

        //Generate Quests
        $itemFirstQuest = Item::factory()->state(['campaign_id' => $campaign->id])->create();
        Quest::factory()->state(['name' => 'Salary Negotiations', 'campaign_id' => $campaign->id])
            ->has(QuestElement::factory()->state(['name' => 'Main Character', 'entity_id' => $firstCharacter->entity->id, 'created_by' => $campaign->created_by]), 'elements')
            ->has(QuestElement::factory()->state(['name' => 'MacGuffin', 'entity_id' => $itemFirstQuest->entity->id, 'created_by' => $campaign->created_by]), 'elements')
            ->create();

        Quest::factory()->state(['name' => 'Fixin Bugs', 'campaign_id' => $campaign->id])
            ->create();

        //Generate Journals
        Journal::factory()->count(2)->state(
            new Sequence(
                ['name' => 'Bilbo\'s journey to middle earth', 'campaign_id' => $campaign->id, 'author_id' => $firstCharacter->entity->id],
                ['name' => 'The tree rings', 'campaign_id' => $campaign->id],
            )
        )
            ->create();

        //Generate Calendars
        Calendar::factory()->state([
            'name' => 'Gregorian', 'campaign_id' => $campaign->id,
            'months' => "[{\"name\":\"January\",\"length\":31,\"type\":\"standard\",\"alias\":\"\"},{\"name\":\"February\",\"length\":28,\"type\":\"standard\",\"alias\":\"\"},{\"name\":\"March\",\"length\":31,\"type\":\"standard\",\"alias\":\"\"},{\"name\":\"April\",\"length\":30,\"type\":\"standard\",\"alias\":\"\"},{\"name\":\"Mai\",\"length\":31,\"type\":\"standard\",\"alias\":\"\"},{\"name\":\"June\",\"length\":30,\"type\":\"standard\",\"alias\":\"\"},{\"name\":\"July\",\"length\":31,\"type\":\"standard\",\"alias\":\"\"},{\"name\":\"August\",\"length\":31,\"type\":\"standard\",\"alias\":\"\"},{\"name\":\"September\",\"length\":30,\"type\":\"standard\",\"alias\":\"\"},{\"name\":\"October\",\"length\":31,\"type\":\"standard\",\"alias\":\"\"},{\"name\":\"November\",\"length\":30,\"type\":\"standard\",\"alias\":\"\"},{\"name\":\"December\",\"length\":31,\"type\":\"standard\",\"alias\":\"\"}]",
            'weekdays' => "[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\",\"Saturday\",\"Sunday\"]",
            'seasons' => "[{\"name\":\"Spring\",\"month\":3,\"day\":21},{\"name\":\"Summer\",\"month\":6,\"day\":21},{\"name\":\"Autumn\",\"month\":9,\"day\":21},{\"name\":\"Winter\",\"month\":12,\"day\":21}]",
            'suffix' => "AD",
            'has_leap_year' => 1,
            'leap_year_amount' => 1,
            'leap_year_month' => 2,
            'leap_year_offset' => 4,
            'leap_year_start' => 4,
            'start_offset' => 5,
            'is_incrementing' => 1,
            'date' => Carbon::now()->toDateString()
        ])
            ->create();

        //Generate Relations
        $firstRelation = Relation::factory()->state(['relation' => 'Best Friend', 'campaign_id' => $campaign->id, 'owner_id' => $secondCharacter->entity->id, 'target_id' => $thirdCharacter->entity->id])->create();
        Relation::factory()->state(['relation' => 'Mortal Enemy', 'campaign_id' => $campaign->id, 'owner_id' => $thirdCharacter->entity->id, 'target_id' => $secondCharacter->entity->id])->for($firstRelation, 'mirror')->create();

        $secondRelation = Relation::factory()->state(['relation' => 'Best Friend', 'campaign_id' => $campaign->id, 'owner_id' => $secondCharacter->entity->id, 'target_id' => $thirdCharacter->entity->id])->create();
        Relation::factory()->state(['relation' => 'Mortal Enemy', 'campaign_id' => $campaign->id, 'owner_id' => $thirdCharacter->entity->id, 'target_id' => $secondCharacter->entity->id])->for($secondRelation, 'mirror')->create();

        return 0;
    }

    /**
     * Load observers.
     */
    private function loadObservers(Campaign $campaign)
    {
        CampaignLocalization::forceCampaign($campaign);
        Ability::observe(AbilityObserver::class);
        Location::observe(LocationObserver::class);
        Character::observe(CharacterObserver::class);
        Calendar::observe(CalendarObserver::class);
        Family::observe(FamilyObserver::class);
        Organisation::observe(OrganisationObserver::class);
        Quest::observe(QuestObserver::class);
        QuestElement::observe(QuestElementObserver::class);
        Relation::observe(RelationObserver::class);
        Journal::observe(JournalObserver::class);
        Event::observe(EventObserver::class);
        Item::observe(ItemObserver::class);
        Tag::observe(TagObserver::class);
        Race::observe(RaceObserver::class);
        Note::observe(NoteObserver::class);
        EntityAbility::observe(EntityAbilityObserver::class);
    }
}
