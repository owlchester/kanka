<?php

namespace App\Console\Commands;

use App\Models\Character;
use App\Models\Race;
use App\User;
use Illuminate\Console\Command;

class GenerateRaces extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'races';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate races';

    /**
     * @var int
     */
    protected $cpt = 0;
    protected $cptRaces = 0;

    /**
     * @var array
     */
    protected $races = [];

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
     * @return mixed
     */
    public function handle()
    {
        Character::whereNotNull('old_race')->chunk(1000, function ($characters) {
            foreach ($characters as $character) {
                // Ignore pre-gen content
                if (in_array($character->slug, ['jamesowlchester', 'irwiegemstone'])) {
                    continue;
                }

                $key = $character->campaign_id . '_' . $character->old_race;
                if (!isset($this->races[$key])) {
                    $race = new Race();
                    $race->campaign_id = $character->campaign_id;
                    $race->name = $character->old_race;
                    $race->save();
                    $this->cptRaces++;

                    $this->races[$key] = $race->id;
                }

                $character->update(['race_id' => $this->races[$key]]);

                $this->cpt++;
            }
        });

        $this->info('Created ' . $this->cptRaces . ' races and updated ' . $this->cpt . ' characters.');
    }
}
