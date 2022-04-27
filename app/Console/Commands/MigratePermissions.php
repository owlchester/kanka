<?php

namespace App\Console\Commands;

use App\Models\CampaignPermission;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigratePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:permissions {cleanup=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate the permission engine to a more performant one. This is needed to make Kanka work with v1.26.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected $count = 0;

    protected $types = [];

    /** @var int[] deletable permissions */
    protected $delete = [];

    protected $map = [
      'read' => CampaignPermission::ACTION_READ,
      'edit' => CampaignPermission::ACTION_EDIT,
      'add' => CampaignPermission::ACTION_ADD,
      'delete' => CampaignPermission::ACTION_DELETE,
      'entity-note' => CampaignPermission::ACTION_POSTS,
      'permission' => CampaignPermission::ACTION_PERMS,
      'manage' => CampaignPermission::ACTION_MANAGE,
      'dashboard' => CampaignPermission::ACTION_DASHBOARD,
      'members' => CampaignPermission::ACTION_MEMBERS,
      'gallery' => CampaignPermission::ACTION_GALLERY,
    ];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info(Carbon::now());

        $this->types = config('entities.ids');
        $this->migrateRolePermissions();
        $this->migrateUserPermissions();
        $this->cleanup();

        $this->info(Carbon::now());
        $this->info('Finished processing ' . $this->count . ' permissions.');
        return 0;
    }

    protected function migrateRolePermissions()
    {
        $this->count = 0;
        $total = CampaignPermission::whereNull('campaign_id')->whereNotNull('campaign_role_id')->count();
        $this->info('Migrating ' . $total . ' role permissions.');
        if ($total === 0) {
            return;
        }

        CampaignPermission::select(['id', 'key', 'campaign_role_id', 'entity_id'])->with('campaignRole')
            ->whereNull('campaign_id')
            ->whereNotNull('campaign_role_id')
            ->chunk(5000, function ($models) {
                /** @var CampaignPermission $model */
                foreach ($models as $model) {
                    try {
                        $campaignID = $model->campaignRole->campaign_id;
                        $action = $this->actionID($model->action());
                        $entityType = !empty($model->entity_id) ? $this->entityType($model->type()) : null;
                        $miscID = !empty($model->entity_id) ? $model->entityId() : null;

                        $this->update($model->id, $campaignID, $action, $miscID, $entityType);

                        $this->count++;
                    } catch (\Exception $e) {
                        throw $e;
                        $this->error('Error on #' . $model->id . '. Action(): ' . $model->action() . '. Key: ' . $model->key);
                    }
                }
                $this->info('- Done ' . $this->count);
            });
        $this->info('Migrated ' . $this->count . ' role permissions.');
    }

    protected function migrateUserPermissions()
    {
        $this->count = 0;
        $total = CampaignPermission::whereNull('campaign_id')->whereNotNull('user_id')->count();
        $this->info('Migrating ' . $total . ' user permissions.');
        if ($total === 0) {
            return;
        }

        CampaignPermission::select(['id', 'key', 'entity_id'])->with('entity')
            ->whereNull('campaign_id')
            ->whereNotNull('user_id')
            ->chunk(5000, function ($models) {
                /** @var CampaignPermission $model */
                foreach ($models as $model) {
                    try {
                        if (empty($model->entity)) {
                            $this->delete[] = $model->id;
                            continue;
                        }
                        $campaignID = $model->entity->campaign_id;
                        $action = $this->actionID($model->action());
                        $entityType = !empty($model->entity_id) ? $this->entityType($model->type()) : null;
                        $miscID = !empty($model->entity_id) ? $model->entityId() : null;

                        $this->update($model->id, $campaignID, $action, $miscID, $entityType);

                        $this->count++;
                    } catch (\Exception $e) {
                        $this->error('Error on #' . $model->id . '. Action(): ' . $model->action() . '. Key: ' . $model->key);
                    }
                }
                $this->info('- Done ' . $this->count);
            });
        $this->info('Migrated ' . $this->count . ' user permissions.');
    }

    /**
     * @param string $action
     * @return int
     */
    protected function actionID(string $action): int
    {
        return $this->map[$action];
    }

    /**
     * Delete old permissions
     */
    protected function cleanup()
    {
        if (empty($this->delete)) {
            return;
        }

        $cleanup = $this->argument('cleanup');
        if (!$cleanup) {
            $this->warn('Found ' . count($this->delete) . ' permissions that can be deleted.');
            $this->warn('call php artisan migrate:permissions 1 to cleanup old permissions.');
            return;
        }

        CampaignPermission::whereIn('id', $this->delete)->delete();
        $this->warn('Deleted ' . count($this->delete) . ' old permissions.');
    }

    /**
     * @param $id
     * @param $campaignID
     * @param $action
     * @param $miscID
     * @param $entityType
     */
    protected function update(int $id, int $campaignID, int $action, int $miscID = null, int $entityType = null)
    {
        $statement = "UPDATE campaign_permissions SET " .
            "`campaign_id` = $campaignID, " .
            "`action` = $action ".
            (!empty($miscID) ? ", `misc_id` = $miscID " : null).
            (!empty($entityType) ? ", `entity_type_id` = $entityType " : null).
            " WHERE `id` = '$id' LIMIT 1";
        DB::statement($statement);
    }

    /**
     * @param string $table
     * @return int
     * @throws \Exception
     */
    protected function entityType(string $table): int
    {
        if (isset($this->types[$table])) {
            return $this->types[$table];
        }
        throw new \Exception('Unknown type ' . $table);
    }
}
