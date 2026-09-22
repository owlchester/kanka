<?php

use App\Models\Campaign;
use App\Models\EntityType;

it('redirects bookmark entity listings to the bookmarks page', function () {
    $this->asUser()->withCampaign();

    $campaign = Campaign::firstOrFail();
    $entityType = EntityType::findOrFail(config('entities.ids.bookmark'));
    $bookmarksUrl = route('bookmarks.index', $campaign);

    $this->get(route('entities.index', [$campaign, $entityType]))
        ->assertRedirect($bookmarksUrl);

    $this->get(route('entities.index-api', [$campaign, $entityType]))
        ->assertRedirect($bookmarksUrl);
});
