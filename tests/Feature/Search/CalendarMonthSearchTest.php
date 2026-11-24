<?php

use App\Models\Calendar;
use App\Models\Campaign;

it('searches only months from calendars visible in the requested campaign', function () {
    $this->asUser()->withCampaign();
    $campaign = Campaign::findOrFail(1);
    $other = Campaign::factory()->create();

    Calendar::factory()->create(['campaign_id' => $campaign->id, 'name' => 'Visible calendar']);
    Calendar::factory()->create(['campaign_id' => $campaign->id, 'name' => 'Private calendar', 'is_private' => true]);
    Calendar::factory()->create(['campaign_id' => $other->id, 'name' => 'Other calendar']);
    $this->asPlayer();

    $this->getJson(route('search.calendar-months', [$campaign, 'q' => 'January']))
        ->assertOk()
        ->assertExactJson([['fullname' => 'January', 'name' => 'January (Visible calendar)']]);
});
