<?php

namespace App\Services\Campaign;

use App\Enums\UserAction;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use App\Models\CampaignRoleUser;
use App\Models\CampaignSetting;
use App\Models\CampaignUser;
use App\Models\EntityType;
use App\Services\Users\CampaignService;
use App\Traits\RequestAware;
use App\Traits\UserAware;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Exception;

class CreateService
{
    use RequestAware;
    use UserAware;

    protected Campaign $campaign;

    public function __construct(protected CampaignService $campaignService)
    {
    }

    public function create(): Campaign
    {
        $data = $this->request->all();
        $data['entry'] = Arr::get($data, 'entry');
        $data['excerpt'] = Arr::get($data, 'excerpt');

        DB::beginTransaction();
        try {
            $this->campaign = Campaign::create($data);

            $this
                ->roles()
                ->settings()
                ->slug()
                ->log();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->campaign;
    }

    protected function roles(): self
    {
        $role = new CampaignUser([
            'user_id' => $this->user->id,
            'campaign_id' => $this->campaign->id,
        ]);
        $role->save();

        $role = CampaignRole::create([
            'campaign_id' => $this->campaign->id,
            'name' => __('campaigns.members.roles.owner'),
            'is_admin' => true,
        ]);

        $readOnlyRoles = [];

        $readOnlyRoles[] = CampaignRole::create([
            'campaign_id' => $this->campaign->id,
            'name' => __('campaigns.members.roles.public'),
            'is_public' => true,
        ]);

        $readOnlyRoles[] = CampaignRole::create([
            'campaign_id' => $this->campaign->id,
            'name' => __('campaigns.members.roles.player'),
        ]);

        $entityTypes = EntityType::default()->get();

        foreach ($readOnlyRoles as $readOnlyRole) {
            foreach ($entityTypes as $entityType) {
                CampaignPermission::create([
                    'campaign_role_id' => $readOnlyRole->id,
                    'access' => true,
                    'action' => CampaignPermission::ACTION_READ,
                    'entity_type_id' => $entityType->id,
                ]);
            }
        }

        CampaignRoleUser::create([
            'campaign_role_id' => $role->id,
            'user_id' => $this->user->id,
        ]);

        return $this;
    }

    protected function slug(): self
    {
        $this->campaign->slug = (string) $this->campaign->id;
        $this->campaign->saveQuietly();
        return $this;
    }

    protected function settings(): self
    {
        $setting = new CampaignSetting([
            'campaign_id' => $this->campaign->id,
            'dice_rolls' => 0,
            'conversations' => 0,
        ]);
        $setting->save();

        return $this;
    }

    protected function log(): self
    {
        // Make sure we save the last campaign id to avoid infinite loops
        $this->campaignService
            ->user($this->user)
            ->campaign($this->campaign)
            ->set();

        $this->user->log(UserAction::campaignNew, ['campaign' => $this->campaign->id]);
        UserCache::clear();
        return $this;
    }
}
