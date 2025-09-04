<?php

namespace App\Services\Caches;

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
use App\Traits\CampaignAware;
use App\Traits\UserAware;

/**
 * Class CampaignCacheService
 */
class CampaignCacheService extends BaseCache
{
    use ApplicationCache;
    use CampaignAware;
    use DashboardCache;
    use FlagCache;
    use MemberCache;
    use PrimaryCache;
    use RoleCache;
    use SettingCache;
    use StyleCache;
    use ThemeCache;
    use ThumbnailCache;
    use UserAware;

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
        return 'campaign_' . $this->campaign->id;
    }

    public function clearSidebar(): self
    {
        $this->forget('campaign_' . $this->campaign->id . '_sidebar');

        return $this;
    }
}
