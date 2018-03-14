<?php

namespace App\Console\Commands;

use App\Campaign;
use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use App\Models\CampaignRoleUser;
use App\Notifications\Release;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
        DB::statement("SET foreign_key_checks=0");
        CampaignPermission::truncate();
        CampaignRoleUser::truncate();
        CampaignRole::truncate();
        DB::statement("SET foreign_key_checks=1");

        $roleCount = $campaignCount = 0;
        $campaigns = Campaign::all();
        foreach ($campaigns as $campaign) {
            $campaignCount++;
            $roleCount++;
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
                $roleCount++;

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
                $roleCount++;

                foreach ($viewers as $member) {
                    $userRole = CampaignRoleUser::create([
                        'campaign_role_id' => $role->id,
                        'user_id' => $member->user_id,
                    ]);
                }
            }
        }

        // Notify everyone
        foreach (User::all() as $user) {
            $user->notify(new Release('permissions'));
        }

        $this->info("Generated $roleCount roles for $campaignCount campaigns");
    }
}
