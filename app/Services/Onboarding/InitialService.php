<?php

namespace App\Services\Onboarding;

use App\Enums\Widget;
use App\Facades\CampaignCache;
use App\Models\CampaignDashboardWidget;
use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use App\Models\CampaignSetting;
use App\Models\Family;
use App\Models\Quest;
use App\Models\Tag;
use App\Traits\CampaignAware;
use App\Traits\RequestAware;
use App\Traits\UserAware;

class InitialService
{
    use CampaignAware;
    use RequestAware;
    use UserAware;

    public function save()
    {
        $this
            ->saveName()
            ->saveType();
    }

    public function skip()
    {
        $this->log('skip');
    }

    protected function log(string $type): void
    {
        $ui = $this->campaign->settings;
        $ui['onboarding'] = $type;
        $this->campaign->update(['settings' => $ui]);
        $this->user->campaignLog(
            $this->campaign->id,
            'onboarding',
            $type,
        );
    }

    protected function saveName(): self
    {
        if (! $this->request->has('name')) {
            return $this;
        }

        $this->campaign->update([
            'name' => $this->request->get('name'),
        ]);

        if (! $this->campaign->wasChanged('name')) {
            return $this;
        }
        $this->user->campaignLog(
            $this->campaign->id,
            'onboarding',
            'rename'
        );

        return $this;
    }

    protected function saveType(): self
    {

        if (! $this->request->has('type')) {
            return $this;
        }
        $type = $this->request->get('type');
        $this->log($type);

        if ($type == 'worldbuilding') {
            $this->worldbuilding();
        } elseif ($type == 'campaign') {
            $this->ttrpg();
        } elseif ($type === 'story') {
            $this->story();
        }

        CampaignCache::campaign($this->campaign)->clear();

        return $this;
    }

    protected function worldbuilding(): void
    {
        /** @var CampaignSetting $settings */
        $settings = $this->campaign->setting;
        $settings->quests = 0;
        $settings->dice_rolls = 0;
        $settings->conversations = 0;
        $settings->abilities = 0;
        $settings->items = 0;
        $settings->save();

        $playerRole = $this->playerRole();
        $playerRole->update(['name' => __('dashboards/onboarding.roles.contributor')]);

        $entityTypes = config('entities.ids');
        foreach ($entityTypes as $entityType => $entityTypeId) {
            foreach ([CampaignPermission::ACTION_READ, CampaignPermission::ACTION_ADD] as $action) {
                CampaignPermission::create([
                    'campaign_role_id' => $playerRole->id,
                    'action' => $action,
                    'entity_type_id' => $entityTypeId,
                    'access' => true,
                ]);
            }
        }
        CampaignPermission::create([
            'campaign_role_id' => $playerRole->id,
            'action' => CampaignPermission::ACTION_GALLERY_UPLOAD,
            'access' => true,
        ]);
        CampaignPermission::create([
            'campaign_role_id' => $playerRole->id,
            'action' => CampaignPermission::ACTION_GALLERY_BROWSE,
            'access' => true,
        ]);

        Family::create([
            'name' => __('dashboards/onboarding.families.varren.title'),
            'campaign_id' => $this->campaign->id,
        ]);
    }

    protected function ttrpg(): void
    {
        $settings = $this->campaign->setting;
        $settings->dice_rolls = 0;
        $settings->timelines = 0;
        $settings->races = 0;
        $settings->save();

        $tag = Tag::create([
            'name' => __('onboarding.ttrpg.tags.npcs'),
            'campaign_id' => $this->campaign->id,
        ]);

        // Give players some basic permissions to view/edit characters
        $playerRole = $this->playerRole();
        $permissions = [
            config('entities.ids.character') => [
                CampaignPermission::ACTION_READ,
                CampaignPermission::ACTION_ADD,
            ],
            config('entities.ids.location') => [
                CampaignPermission::ACTION_READ,
            ],
            config('entities.ids.family') => [
                CampaignPermission::ACTION_READ,
            ],
            config('entities.ids.quest') => [
                CampaignPermission::ACTION_READ,
            ],
            config('entities.ids.journal') => [
                CampaignPermission::ACTION_READ,
                CampaignPermission::ACTION_ADD,
            ],
        ];
        foreach ($permissions as $entityType => $actions) {
            foreach ($actions as $action) {
                CampaignPermission::create([
                    'campaign_role_id' => $playerRole->id,
                    'action' => $action,
                    'entity_type_id' => $entityType,
                    'access' => true,
                ]);
            }
        }
        CampaignPermission::create([
            'campaign_role_id' => $playerRole->id,
            'action' => CampaignPermission::ACTION_GALLERY_UPLOAD,
            'access' => true,
        ]);

        CampaignDashboardWidget::create([
            'campaign_id' => $this->campaign->id,
            'filters' => ['is_completed' => false, 'text' => __('dashboards/onboarding.widgets.active-quests')],
            'position' => 3,
            'widget' => Widget::Recent,
            'entity_type_id' => config('entities.ids.quest'),
        ]);

        Quest::create([
            'name' => __('dashboards/onboarding.quests.crown.title'),
            'campaign_id' => $this->campaign->id,
        ]);
    }

    protected function story(): void
    {
        $settings = $this->campaign->setting;
        $settings->quests = 0;
        $settings->dice_rolls = 0;
        $settings->conversations = 0;
        $settings->abilities = 0;
        $settings->calendars = 0;
        $settings->save();

        $playerRole = $this->playerRole();
        $playerRole->update(['name' => __('dashboards/onboarding.roles.co-writer')]);
    }

    protected function playerRole(): CampaignRole
    {
        return $this->campaign->roles()->where('is_admin', 0)->where('is_public', 0)->first();
    }
}
