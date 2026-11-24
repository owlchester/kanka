<?php

namespace App\Services\Caches;

use App\Facades\CampaignLocalization;
use App\Models\Campaign;
use App\Services\Caches\Traits\Campaign\ApplicationCache;
use App\Services\Caches\Traits\Campaign\DashboardCache;
use App\Services\Caches\Traits\Campaign\FlagCache;
use App\Services\Caches\Traits\Campaign\MemberCache;
use App\Services\Caches\Traits\Campaign\RoleCache;
use App\Services\Caches\Traits\Campaign\SettingCache;
use App\Services\Caches\Traits\Campaign\StyleCache;
use App\Services\Caches\Traits\Campaign\ThemeCache;
use App\Services\Caches\Traits\Campaign\ThumbnailCache;
use App\Services\Caches\Traits\PrimaryCache;

/**
 * Class CampaignCacheService
 */
class CampaignCacheService extends BaseCache
{
    use ApplicationCache;
    use DashboardCache;
    use FlagCache;
    use MemberCache;
    use PrimaryCache;
    use RoleCache;
    use SettingCache;
    use StyleCache;
    use ThemeCache;
    use ThumbnailCache;

    private ?Campaign $explicitCampaign = null;

    public function campaign(Campaign $campaign): self
    {
        $this->primaryStore();
        $scoped = clone $this;
        $scoped->explicitCampaign = $campaign;

        return $scoped;
    }

    protected function activeCampaign(): Campaign
    {
        return $this->explicitCampaign ?? CampaignLocalization::getCampaign();
    }

    protected function primaryData(): array
    {
        return [
            'modules' => $this->formatSettings(),
            'dashboards' => $this->formatDashboards(),
            'members' => $this->formatMembers(),
            'admin-role' => $this->formatAdminRole(),
            'applications' => $this->formatApplications(),
            'flags' => $this->formatFlags(),
            'time' => time(),
        ];
    }

    protected function primaryKey(): string
    {
        return 'campaign_' . $this->activeCampaign()->id;
    }

    public function clearSidebar(): self
    {
        $this->forget('campaign_' . $this->activeCampaign()->id . '_sidebar');

        return $this;
    }
}
