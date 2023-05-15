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
use Illuminate\Support\Str;
use App\Facades\CampaignLocalization;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Console\Command;


class DummyJobLog extends Command
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
        $campaignId = $this->argument('campaign');
        $this->loadObservers();

        //Generate Characters and Locations
        Location::factory()
            ->state(['campaign_id' => $campaignId, 'name' => 'Thaelia', 'slug' => Str::slug('Thaelia')])
            ->has(Character::factory()->state(['campaign_id' => $campaignId]))
            ->has(Location::factory()
                    ->state(['name' => 'March', 'campaign_id' => $campaignId, 'slug' => Str::slug('March')])
                    ->has(Location::factory()
                        ->state(['name' => 'Adestry', 'campaign_id' => $campaignId, 'slug' => Str::slug('Adestry')])))
                    ->has(Location::factory()
                        ->state(['name' => 'Tilley', 'campaign_id' => $campaignId, 'slug' => Str::slug('Tilley')])
                        ->has(Location::factory()
                            ->state(['name' => 'Carrothead', 'campaign_id' => $campaignId, 'slug' => Str::slug('Carrothead')])))
                    ->has(Character::factory()->count(2)->state(['campaign_id' => $campaignId]))
            ->has(Location::factory()->state(['name' => 'Orlene', 'campaign_id' => $campaignId, 'slug' => Str::slug('Orlene')]))
                ->has(Location::factory()
                    ->state(['name' => 'Owlchester', 'campaign_id' => $campaignId, 'slug' => Str::slug('Owlchester')]))
            ->create();

        Location::factory()
            ->state(['campaign_id' => $campaignId, 'name' => 'Medina', 'slug' => Str::slug('Medina')])
            ->has(Location::factory()->count(2)->state(new Sequence(['name' => 'Torchio', 'campaign_id' => $campaignId, 'slug' => Str::slug('Torchio')],['name' => 'Urdino', 'campaign_id' => $campaignId, 'slug' => Str::slug('Urdino')])))
            ->has(Character::factory()->count(2)->state(['campaign_id' => $campaignId]))
            ->create();

        //Generate Families
        Family::factory()
            ->state(['campaign_id' => $campaignId, 'name' => 'Graff', 'slug' => Str::slug('Graff')])
            ->has(Family::factory()->state(['name' => 'Market', 'campaign_id' => $campaignId, 'slug' => Str::slug('Market')]))
            ->create();
        Family::factory()->state(['name' => 'Joren', 'campaign_id' => $campaignId, 'slug' => Str::slug('Joren')])->create();

        //Generate Organisations
        Organisation::factory()
            ->state(['campaign_id' => $campaignId, 'name' => 'Kankappy Cult', 'slug' => Str::slug('Kankappy Cult')])
            ->has(Organisation::factory()->state(['name' => 'Fun Police', 'campaign_id' => $campaignId, 'slug' => Str::slug('Fun Police')]))
            ->create();
        Organisation::factory()->state(['name' => 'Great Reset', 'campaign_id' => $campaignId, 'slug' => Str::slug('Great Reset')])->create();
        
        //Generate Events
        Event::factory()->count(4)->state(
            new Sequence(
                ['name' => 'The Great War', 'campaign_id' => $campaignId, 'slug' => Str::slug('The Great War')],
                ['name' => 'Northern Rebellion', 'campaign_id' => $campaignId, 'slug' => Str::slug('Northern Rebellion')],
                ['name' => 'Peace of the Sea', 'campaign_id' => $campaignId, 'slug' => Str::slug('Peace of the Sea')],
                ['name' => 'Royal Wedding', 'campaign_id' => $campaignId, 'slug' => Str::slug('Royal Wedding')],
                ))
        ->create();

        //Generate Items
        Item::factory()->count(5)->state(
            new Sequence(
                ['name' => 'Bow', 'campaign_id' => $campaignId, 'slug' => Str::slug('Bow')],
                ['name' => 'Crowbar', 'campaign_id' => $campaignId, 'slug' => Str::slug('Crowbar')],
                ['name' => 'Shield', 'campaign_id' => $campaignId, 'slug' => Str::slug('Shield')],
                ['name' => 'Sword', 'campaign_id' => $campaignId, 'slug' => Str::slug('Sword')],
                ['name' => 'Potion', 'campaign_id' => $campaignId, 'slug' => Str::slug('Potion')],
                ))
        ->create();

        //Generate Notes
        Note::factory()->count(3)->state(
            new Sequence(
                ['name' => 'Aromas of Geneva', 'campaign_id' => $campaignId, 'slug' => Str::slug('Aromas of Geneva')],
                ['name' => 'Pottery Stacking', 'campaign_id' => $campaignId, 'slug' => Str::slug('Pottery Stacking')],
                ['name' => 'Making Friends', 'campaign_id' => $campaignId, 'slug' => Str::slug('Making Friends')],
                ))
        ->create();

        //Generate Races
        Race::factory()
            ->state(['campaign_id' => $campaignId, 'name' => 'Elf', 'slug' => Str::slug('Elf')])
            ->has(Race::factory()
                    ->state(['name' => 'Wood elf', 'campaign_id' => $campaignId, 'slug' => Str::slug('Wood elf')])
                    ->has(Race::factory()
                        ->state(['name' => 'Leaf elf', 'campaign_id' => $campaignId, 'slug' => Str::slug('Leaf elf')])))
            ->has(Race::factory()->state(['name' => 'High elf', 'campaign_id' => $campaignId, 'slug' => Str::slug('High elf')]))
            ->create();

        Race::factory()->count(2)->state(
            new Sequence(
                ['name' => 'Human', 'campaign_id' => $campaignId, 'slug' => Str::slug('Human')],
                ['name' => 'Owlbear', 'campaign_id' => $campaignId, 'slug' => Str::slug('Owlbear')],
                ))
        ->create();

        //Generate Tags
        Tag::factory()->count(3)->state(
            new Sequence(
                ['name' => '🧛🏻‍♂️', 'campaign_id' => $campaignId, 'slug' => Str::slug('🧛🏻‍♂️'), 'colour' => 'maroon'],
                ['name' => 'Important', 'campaign_id' => $campaignId, 'slug' => Str::slug('Important'), 'colour' => 'aqua'],
                ['name' => 'NPC', 'campaign_id' => $campaignId, 'slug' => Str::slug('NPC'), 'colour' => 'grey'],
                ))
        ->create();

        return 0;
    }

    /**
     * Load observers.
     */
    private function loadObservers()
    {
        $campaign = Campaign::where('id', $this->argument('campaign'))->first();
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
