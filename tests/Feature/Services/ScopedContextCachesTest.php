<?php

use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Facades\Module;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\CampaignRole;
use App\Models\CampaignSetting;
use App\Models\User;

it('follows CampaignLocalization switches dynamically without priming CampaignCache or Module', function () {
    $this->asUser()->withCampaign();

    $campaign2 = Campaign::factory()->create(['slug' => 'dynamic-campaign-2']);
    CampaignRole::create([
        'campaign_id' => $campaign2->id,
        'name' => 'Owner',
        'is_admin' => true,
    ]);
    CampaignSetting::create([
        'campaign_id' => $campaign2->id,
        'dice_rolls' => 1,
        'conversations' => 1,
    ]);

    // Warm CampaignCache and Module on campaign 1
    expect(CampaignCache::settings()->get('dice_rolls'))->toBe(0);

    // Switch CampaignLocalization to campaign 2 with ZERO priming calls on CampaignCache or Module
    CampaignLocalization::forceCampaign($campaign2);

    expect(CampaignCache::settings()->get('dice_rolls'))->toBe(1)
        ->and(Module::singular('character', 'Fallback'))->toBe('Fallback');
});

it('does not leak explicit campaign or user overrides into subsequent default calls', function () {
    $this->asUser()->withCampaign();
    $campaign1 = Campaign::findOrFail(1);

    $campaign2 = Campaign::factory()->create(['slug' => 'override-campaign-2']);
    CampaignRole::create([
        'campaign_id' => $campaign2->id,
        'name' => 'Owner',
        'is_admin' => true,
    ]);
    CampaignSetting::create([
        'campaign_id' => $campaign2->id,
        'dice_rolls' => 1,
        'conversations' => 1,
    ]);

    $otherUser = User::factory()->create(['name' => 'Other User']);

    // Explicitly query campaign 2 and otherUser
    expect(CampaignCache::campaign($campaign2)->settings()->get('dice_rolls'))->toBe(1)
        ->and(UserCache::user($otherUser)->campaign($campaign1)->roles())->toBeEmpty();

    // Subsequent default calls must still reflect campaign 1 and $admin
    expect(CampaignCache::settings()->get('dice_rolls'))->toBe(0)
        ->and(UserCache::roles()->pluck('is_admin')->all())->toContain(true);
});

it('shares per-request primary cache invalidation when clearing via a scoped clone', function () {
    $this->asUser()->withCampaign();
    $campaign1 = CampaignLocalization::getCampaign();

    expect(CampaignCache::settings()->get('dice_rolls'))->toBe(0);

    $campaign1->setting->update(['dice_rolls' => 1]);
    CampaignCache::campaign($campaign1)->clear();

    expect(CampaignCache::settings()->get('dice_rolls'))->toBe(1);
});

it('does not leak fallback flag across Module calls', function () {
    $this->asUser()->withCampaign();

    $withFallback = Module::fallback()->plural('character');
    $withoutFallback = Module::plural('character', 'custom.key');

    expect($withFallback)->toBe(__('entities.characters'))
        ->and($withoutFallback)->toBe('custom.key');
});
