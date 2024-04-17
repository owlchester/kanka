<?php

namespace App\Console\Commands\Migrations;

use App\Models\Organisation;
use App\Models\OrganisationLocation;
use Illuminate\Console\Command;

class MigrateOrganisationLocations extends Command
{
    public $count = 0;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'organisation:locations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate organisation location to locations';

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
        OrganisationLocation::truncate();
        Organisation::whereNotNull('location_id')->chunk(1000, function ($organisations) {
            $this->info('1000 Chunk...');
            foreach ($organisations as $organisation) {
                $organisation->locations()->attach($organisation->location_id);
                $this->count++;
            }
        });

        $this->info('Migrated ' . $this->count . ' organisations');
        return 0;
    }
}
