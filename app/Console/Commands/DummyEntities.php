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
            ->state(['name' => 'Thaelia'])
            ->has(Character::factory())
            ->has(Location::factory()
                    ->state(['name' => 'March'])
                    ->has(Location::factory()
                        ->state(['name' => 'Adestry'])))
                    ->has(Location::factory()
                        ->state(['name' => 'Tilley'])
                        ->has(Location::factory()
                            ->state(['name' => 'Carrothead'])))
                    ->has(Character::factory()->count(2))
            ->has(Location::factory()->state(['name' => 'Orlene']))
                ->has(Location::factory()
                    ->state(['name' => 'Owlchester']))
            ->create();

        Location::factory()
            ->state(['name' => 'Medina'])
            ->has(Location::factory()->count(2)->state(new Sequence(['name' => 'Torchio'],['name' => 'Urdino'])))
            ->has(Character::factory()->count(2))
            ->create();

        //Generate Families
        Family::factory()
            ->state(['name' => 'Graff'])
            ->has(Family::factory()->state(['name' => 'Market']))
            ->create();
        Family::factory()->state(['name' => 'Joren'])->create();

        //Generate Organisations
        Organisation::factory()
            ->state(['name' => 'Kankappy Cult'])
            ->has(Organisation::factory()->state(['name' => 'Fun Police']))
            ->create();
        Organisation::factory()->state(['name' => 'Great Reset'])->create();
        
        //Generate Events
        Event::factory()->count(4)->state(
            new Sequence(
                ['name' => 'The Great War'],
                ['name' => 'Northern Rebellion'],
                ['name' => 'Peace of the Sea'],
                ['name' => 'Royal Wedding'],
                ))
        ->create();

        //Generate Items
        Item::factory()->count(5)->state(
            new Sequence(
                ['name' => 'Bow'],
                ['name' => 'Crowbar'],
                ['name' => 'Shield'],
                ['name' => 'Sword'],
                ['name' => 'Potion'],
                ))
        ->create();

        //Generate Notes
        Note::factory()->count(3)->state(
            new Sequence(
                ['name' => 'Aromas of Geneva'],
                ['name' => 'Pottery Stacking'],
                ['name' => 'Making Friends'],
                ))
        ->create();

        //Generate Races
        Race::factory()
            ->state([ 'name' => 'Elf'])
            ->has(Race::factory()
                    ->state(['name' => 'Wood elf'])
                    ->has(Race::factory()
                        ->state(['name' => 'Leaf elf'])))
            ->has(Race::factory()->state(['name' => 'High elf']))
            ->create();

        Race::factory()->count(2)->state(
            new Sequence(
                ['name' => 'Human'],
                ['name' => 'Owlbear'],
                ))
        ->create();

        //Generate Tags
        Tag::factory()->count(3)->state(
            new Sequence(
                ['name' => '🧛🏻‍♂️', 'colour' => 'maroon'],
                ['name' => 'Important', 'colour' => 'aqua'],
                ['name' => 'NPC', 'colour' => 'grey'],
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
