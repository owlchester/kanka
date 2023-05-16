<?php

namespace App\Console\Commands;

use App\Models\Location;
use App\Models\Family;
use App\Models\Note;
use App\Models\Character;
use App\Models\Organisation;
use App\Models\Event;
use App\Models\Item;
use App\Models\Tag;
use App\Models\Race;
use App\Models\Campaign;
use App\Observers\LocationObserver;
use App\Observers\CharacterObserver;
use App\Observers\FamilyObserver;
use App\Observers\OrganisationObserver;
use App\Observers\EventObserver;
use App\Observers\ItemObserver;
use App\Observers\TagObserver;
use App\Observers\RaceObserver;
use App\Observers\NoteObserver;
use App\Facades\CampaignLocalization;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Console\Command;

class DummyEntities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign:populate {campaign}';

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

        $this->loadObservers($campaign);

        //Generate Characters and Locations
        Location::factory()
            ->state(['name' => 'Thaelia', 'campaign_id' => $campaign->id])
            ->has(Character::factory()->state(['campaign_id' => $campaign->id]))
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

        Location::factory()
            ->state(['name' => 'Medina', 'campaign_id' => $campaign->id])
            ->has(Location::factory()->count(2)->state(new Sequence(
                ['name' => 'Torchio', 'campaign_id' => $campaign->id],
                ['name' => 'Urdino', 'campaign_id' => $campaign->id]
            )))
            ->has(Character::factory()->state(['campaign_id' => $campaign->id])->count(2))
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
            ->state([ 'name' => 'Elf', 'campaign_id' => $campaign->id])
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

        return 0;
    }

    /**
     * Load observers.
     */
    private function loadObservers(Campaign $campaign)
    {
        CampaignLocalization::forceCampaign($campaign);
        Location::observe(LocationObserver::class);
        Character::observe(CharacterObserver::class);
        Family::observe(FamilyObserver::class);
        Organisation::observe(OrganisationObserver::class);
        Event::observe(EventObserver::class);
        Item::observe(ItemObserver::class);
        Tag::observe(TagObserver::class);
        Race::observe(RaceObserver::class);
        Note::observe(NoteObserver::class);
    }
}
