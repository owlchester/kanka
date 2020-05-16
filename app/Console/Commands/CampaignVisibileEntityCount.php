<?php

namespace App\Console\Commands;

use App\Facades\EntityPermission;
use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use App\Models\Entity;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class CampaignVisibileEntityCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign:public';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the visible entity count for campaigns';

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
        Campaign::public()->chunk(1000, function ($campaigns) {
            /** @var Campaign $campaign */
            foreach ($campaigns as $campaign) {
                $this->count++;
                $count = $this->campaignCount($campaign);

                //$this->info('Campaign ' . $campaign->id . ' has ' . $count . ' public entities.');

                $campaign->visible_entity_count = $count;
                $campaign->withObservers = false;
                $campaign->save();
            }
        });

        $this->info('Updated ' . $this->count . ' public campaigns.');
    }

    /**
     * @param Campaign $campaign
     * @return int number of public entities
     */
    protected function campaignCount(Campaign $campaign):int
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
            if ($permission->action() == 'read') {
                if (!empty($permission->entity_id)) {
                    $ids[] = $permission->entity_id;
                } else {
                    $types[] = $permission->type();
                }
            }
        }


        // Now that we have the types and ids, we can count the number of visible entities in this campaign
        return Entity::where(['campaign_id' => $campaign->id])
            ->where('is_private', false)
            ->where(function ($sub) use ($types, $ids) {
                return $sub->whereIn('type', $types)
                    ->orWhereIn('id', $ids);
            })
            ->count();
    }
}
