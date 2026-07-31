<?php

use App\Models\Campaign;
use App\Models\User;
use App\Services\Gallery\UploadService;
use Illuminate\Http\UploadedFile;

it('saves the uploaded image dimensions to metadata', function () {
    $user = User::factory()->create();
    $this->actingAs($user)->withCampaign();
    $campaign = Campaign::find(1);

    $file = UploadedFile::fake()->image('map.png', 80, 40);

    $service = app(UploadService::class)->campaign($campaign)->user($user);
    $service->file($file);

    $image = $service->image();

    expect($image->width())->toBe(80);
    expect($image->height())->toBe(40);
});
