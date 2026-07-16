<?php

use App\Facades\CampaignCache;
use App\Models\Campaign;
use Illuminate\Support\Facades\Cache;

it('rebuilds dashboards from a partial campaign cache', function () {
    $this->asUser()->withCampaign();

    Cache::put('campaign_1', ['thumbnails' => []], 3600);

    $dashboards = CampaignCache::campaign(Campaign::findOrFail(1))->dashboards();

    expect($dashboards)->toBeArray()
        ->and($dashboards)->toHaveKeys(['admin', 'public']);

    expect(Cache::get('campaign_1'))->toHaveKeys([
        'modules',
        'dashboards',
        'members',
        'admin-role',
        'applications',
        'flags',
        'time',
    ]);
});
