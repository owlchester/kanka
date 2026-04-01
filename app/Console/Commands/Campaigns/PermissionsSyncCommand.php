<?php

namespace App\Console\Commands\Campaigns;

use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class PermissionsSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaigns:permissions {campaign}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync permissions from one campaign role to another';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $campaign = Campaign::find($this->argument('campaign'));

        if (! $campaign) {
            $this->error('Campaign not found.');

            return 1;
        }

        $this->info("Campaign: {$campaign->name}");

        /** @var Collection<int, CampaignRole> $roles */
        $roles = CampaignRole::where('campaign_id', $campaign->id)->get();

        if ($roles->count() < 2) {
            $this->error('Campaign must have at least two roles to sync permissions.');

            return 1;
        }

        $roleChoices = $roles->mapWithKeys(fn (CampaignRole $role) => [$role->id => $role->name])->all();

        $sourceName = $this->choice('Select the source role (permissions will be copied from)', $roleChoices);
        $sourceRole = $roles->firstWhere('name', $sourceName);

        $targetName = $this->choice('Select the target role (permissions will be copied to)', $roleChoices);
        $targetRole = $roles->firstWhere('name', $targetName);

        if ($sourceRole->id === $targetRole->id) {
            $this->error('Source and target roles must be different.');

            return 1;
        }

        $existingPermissionsCount = CampaignPermission::where('campaign_role_id', $targetRole->id)->count();

        if ($existingPermissionsCount > 0) {
            if (! $this->confirm("The target role \"{$targetRole->name}\" already has {$existingPermissionsCount} permission(s). Clear them before syncing?")) {
                $this->info('Sync cancelled.');

                return 0;
            }

            CampaignPermission::where('campaign_role_id', $targetRole->id)->delete();
            $this->info("Cleared {$existingPermissionsCount} existing permission(s) from \"{$targetRole->name}\".");
        }

        $sourceRole->duplicate($targetRole);

        $createdCount = CampaignPermission::where('campaign_role_id', $targetRole->id)->count();

        $this->info("Successfully copied {$createdCount} permission(s) from \"{$sourceRole->name}\" to \"{$targetRole->name}\".");

        return 0;
    }
}
