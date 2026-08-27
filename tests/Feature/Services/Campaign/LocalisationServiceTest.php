<?php

use App\Facades\CampaignLocalization;
use App\Models\Campaign;
use App\Services\Campaign\LocalisationService;
use Illuminate\Support\Facades\Route;

it('seeds the campaign context from the ACL route binding', function () {
    $this->asUser()->withCampaign();
    $campaign = Campaign::findOrFail(1);

    Route::get('/campaign-context-test/{campaign}', function () {
        return response()->json([
            'campaign_id' => CampaignLocalization::getCampaign()?->id,
        ]);
    })->middleware('web');

    $this->getJson('/campaign-context-test/' . $campaign->slug)
        ->assertSuccessful()
        ->assertJsonPath('campaign_id', $campaign->id);
});

it('starts without a campaign when no route context exists', function () {
    expect((new LocalisationService)->getCampaign())->toBeNull();
});

it('uses a forced campaign without a route context', function () {
    $campaign = new Campaign(['id' => 42]);
    $service = new LocalisationService;

    $service->forceCampaign($campaign);

    expect($service->hasCampaign())->toBeTrue()
        ->and($service->getCampaign())->toBe($campaign);
});

it('clears the campaign and console context', function () {
    $service = new LocalisationService;
    $service->forceCampaign(new Campaign(['id' => 42]));
    $service->setConsoleCampaign(42);

    $service->clear();

    expect($service->hasCampaign())->toBeFalse()
        ->and($service->getConsoleCampaign())->toBe(0);
});
