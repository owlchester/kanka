<?php

namespace App\Console\Commands\Campaigns;

use App\Enums\Permission;
use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use App\Models\Entity;
use App\Traits\HasJobLog;
use Illuminate\Console\Command;

class VisibileEntityCountCommand extends Command
{
    use HasJobLog;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaigns:public';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the visible entity count for campaigns';

    /** @var int Number of processed elements */
    protected int $count = 0;

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
     */
    public function handle(): void
    {
        Campaign::public()->chunk(1000, function ($campaigns): void {
            /** @var Campaign $campaign */
            foreach ($campaigns as $campaign) {
                $this->count++;
                $count = $this->campaignCount($campaign);

                // $this->info('Campaign ' . $campaign->id . ' has ' . $count . ' public entities.');

                $campaign->visible_entity_count = $count;
                $campaign->saveQuietly();
            }
        });
        $log = "Updated {$this->count} public campaigns.";
        $this->info($log);
        $this->log($log);
    }

    /**
     * @return int number of public entities
     */
    protected function campaignCount(Campaign $campaign): int
    {
        /** @var CampaignRole $public */
        $public = CampaignRole::where([
            'campaign_id' => $campaign->id,
            'is_public' => true])
            ->with('permissions')
            ->first();

        $types = $ids = [];
        /** @var CampaignPermission $permission */
        foreach ($public->permissions as $permission) {
            if ($permission->isAction(Permission::View->value)) {
                if (! empty($permission->entity_id)) {
                    $ids[] = $permission->entity_id;
                } else {
                    $types[] = $permission->entity_type_id;
                }
            }
        }

        // Now that we have the types and ids, we can count the number of visible entities in this campaign
        return Entity::where(['campaign_id' => $campaign->id])
            ->where('is_private', false)
            ->where(function ($sub) use ($types, $ids) {
                return $sub->inTypes($types)
                    ->orWhereIn('id', $ids);
            })
            ->count();
    }
}
