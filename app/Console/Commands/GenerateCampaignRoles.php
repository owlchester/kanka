<?php

namespace App\Console\Commands;

use App\Campaign;
use App\Models\CampaignRole;
use App\Models\CampaignRoleUser;
use Illuminate\Console\Command;

class GenerateCampaignRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign:role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new roles for all campaigns';

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
        $existingRoles = CampaignRole::get();
        foreach ($existingRoles as $role) {
            $role->delete();
        }

        $campaigns = Campaign::all();
        foreach ($campaigns as $campaign) {
            $role = CampaignRole::create([
                'campaign_id' => $campaign->id,
                'is_admin' => true,
                'name' => 'Owner',
            ]);

            // Attach users
            foreach ($campaign->owners as $owner) {
                $userRole = CampaignRoleUser::create([
                    'campaign_role_id' => $role->id,
                    'user_id' => $owner->user_id,
                ]);
            }

            // Need to do the other roles?
            $members = $campaign->members()->where('role', 'member')->get();
            if (!empty($members)) {
                $role = CampaignRole::create([
                    'campaign_id' => $campaign->id,
                    'is_admin' => false,
                    'name' => 'Member',
                ]);

                // Assign roles

                foreach ($members as $member) {
                    $userRole = CampaignRoleUser::create([
                        'campaign_role_id' => $role->id,
                        'user_id' => $member->user_id,
                    ]);
                }
            }

            $viewers = $campaign->members()->where('role', 'viewer')->get();
            if (!empty($viewers)) {
                $role = CampaignRole::create([
                    'campaign_id' => $campaign->id,
                    'is_admin' => false,
                    'name' => 'Viewer',
                ]);

                foreach ($viewers as $member) {
                    $userRole = CampaignRoleUser::create([
                        'campaign_role_id' => $role->id,
                        'user_id' => $member->user_id,
                    ]);
                }
            }
        }
    }
}
