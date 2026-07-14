<?php

use App\Models\Campaign;

it('preserves custom sidebar settings when saving campaign defaults', function () {
    $this->asUser()->withCampaign([
        'ui_settings' => [
            'sidebar' => [
                'order' => ['characters' => null],
                'labels' => ['characters' => 'Heroes'],
            ],
        ],
    ]);

    $this->post(route('campaign-defaults-save', 'test-campaign'), [
        'ui_settings' => [
            'connections' => 1,
            'connections_mode' => 2,
            'post_collapsed' => 1,
            'descendants' => 1,
        ],
    ])
        ->assertRedirect(route('campaign-defaults', 'test-campaign'));

    $campaign = Campaign::firstOrFail()->refresh();

    expect($campaign->ui_settings)
        ->toMatchArray([
            'sidebar' => [
                'order' => ['characters' => null],
                'labels' => ['characters' => 'Heroes'],
            ],
            'connections' => 1,
            'connections_mode' => 2,
            'post_collapsed' => 1,
            'descendants' => 1,
        ]);
});
