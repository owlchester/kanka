<?php

namespace App\Console\Commands;

use App\Models\CampaignPermission;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GeneratePermissionEntity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:entity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all the campaign permissions to include links to the entities.';

    /**
     * @var int
     */
    protected $count = 0;

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

        CampaignPermission::where([
            ['key', 'NOT LIKE', '%read'],
            ['key', 'NOT LIKE', '%edit'],
            ['key', 'NOT LIKE', '%add'],
            ['key', 'NOT LIKE', '%delete'],
            ['key', 'NOT LIKE', '%permission'],
        ])->chunk(2000, function ($models) {
            /** @var CampaignPermission $permission */
            foreach ($models as $permission) {
                $id = $permission->entityId();
                if (is_numeric($id)) {
                    // Get the real entity?
                    $type = str_singular($permission->table_name);
                    $entity = DB::table('entities')->where('type', $type)->where('entity_id', $id)->first();
                    if ($entity) {
                        $permission->entity_id = $entity->id;
                        $permission->save();
                        $this->count++;
                    } else {
                        $permission->delete();
                        $this->warn("Missing id $id for type '$type'. Deleted.");
                    }
                }
            }
        });

        $this->info("Updated {$this->count} entities.");

        return true;
    }
}
