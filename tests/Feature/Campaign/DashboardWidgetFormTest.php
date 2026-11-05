<?php

use App\Models\CampaignDashboard;

it('offers the default dashboard when creating a widget for a premium campaign', function () {
    $this->asUser()->withCampaign(['boost_count' => 4]);
    $dashboard = CampaignDashboard::create([
        'campaign_id' => 1,
        'name' => 'Custom dashboard',
        'created_by' => 1,
    ]);

    $this->get('/w/test-campaign/campaign_dashboard_widgets/create?widget=preview')
        ->assertSuccessful()
        ->assertSee('<option value=""', false)
        ->assertSee(__('dashboard.dashboards.default.title'))
        ->assertSee('<option value="' . $dashboard->id . '"', false)
        ->assertSee('Custom dashboard');
});

it('offers a placement dashboard selector on the header widget form', function () {
    $this->asUser()->withCampaign(['boost_count' => 4]);
    CampaignDashboard::create([
        'campaign_id' => 1,
        'name' => 'Custom dashboard',
        'created_by' => 1,
    ]);

    $this->get('/w/test-campaign/campaign_dashboard_widgets/create?widget=header')
        ->assertSuccessful()
        ->assertSee('name="dashboard_id"', false)
        ->assertSee('name="target_dashboard_id"', false);
});
