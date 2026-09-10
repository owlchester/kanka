<?php

use App\Models\CampaignBoost;

it('does not apply the cooldown to automatically assigned premium campaigns', function () {
    $this->asUser()->withCampaign();
    app()->instance('env', 'production');

    $automaticallyAssigned = CampaignBoost::create([
        'campaign_id' => 1,
        'user_id' => 1,
        'automatically_assigned' => true,
    ]);
    $manual = CampaignBoost::create([
        'campaign_id' => 1,
        'user_id' => 1,
    ]);

    expect($automaticallyAssigned->inCooldown())->toBeFalse()
        ->and($manual->inCooldown())->toBeTrue();
});
