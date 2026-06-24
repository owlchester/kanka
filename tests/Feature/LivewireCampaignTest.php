<?php

use App\Models\Campaign;
use Database\Seeders\VisibilitiesTableSeeder;
use Illuminate\Support\Facades\URL;

it('livewire update uri includes campaign slug when url defaults are set', function () {
    URL::defaults(['campaign' => 'my-campaign']);
    expect(app('livewire')->getUpdateUri())->toBe('/livewire/update/my-campaign');
});

it('livewire update route resolves campaign binding for member', function () {
    $this->asUser()->withCampaign();
    $campaign = Campaign::first();

    $response = $this->post('/livewire/update/' . $campaign->slug, []);

    // 404 means campaign binding failed; any other status means routing worked
    expect($response->status())->not->toBe(404);
});

it('livewire update route blocks access to unauthorized campaign', function () {
    $this->asUser(); // user has no campaigns
    $this->seed(VisibilitiesTableSeeder::class);
    $otherCampaign = Campaign::factory()->create(['slug' => 'other-campaign']);

    $response = $this->post('/livewire/update/' . $otherCampaign->slug, []);

    $response->assertStatus(404);
});

it('livewire update uri is bare when no campaign url default is set', function () {
    expect(app('livewire')->getUpdateUri())->toBe('/livewire/update');
});
