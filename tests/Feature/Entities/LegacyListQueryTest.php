<?php

it('loads the bookmark list when ordering by a bookmark field', function () {
    $this->asUser()
        ->withCampaign()
        ->withBookmarks()
        ->get('/w/1/bookmarks?order=name&desc=1')
        ->assertSuccessful();
});

it('loads the legacy relations list', function () {
    $this->asUser()
        ->withCampaign()
        ->get('/w/1/relations')
        ->assertSuccessful();
});
