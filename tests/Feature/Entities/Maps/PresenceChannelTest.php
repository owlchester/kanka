<?php

use App\Models\Map;
use App\Models\User;

beforeEach(function () {
    // The app's default broadcaster is BROADCAST_DRIVER=reverb, which Laravel's
    // BroadcastManager resolves to the same PusherBroadcaster used by the "pusher"
    // driver (BroadcastManager::createReverbDriver() delegates to createPusherDriver()).
    // In the testing environment BROADCAST_DRIVER isn't set, so the broadcaster
    // defaults to "null", whose auth()/validAuthenticationResponse() are no-ops and
    // never actually invoke the routes/channels.php closures. Forcing the "pusher"
    // driver here (with dummy local credentials, no network calls are made) exercises
    // the real channel-authorization code path that reverb uses in production.
    config([
        'broadcasting.default' => 'pusher',
        'broadcasting.connections.pusher.key' => 'test-key',
        'broadcasting.connections.pusher.secret' => 'test-secret',
        'broadcasting.connections.pusher.app_id' => 'test-app-id',
    ]);

    // routes/channels.php was already `require`d during app boot (by
    // BroadcastServiceProvider::boot()), before the config() override above ran —
    // at that point it registered the channel closures against the "null" driver
    // instance. Broadcaster channel registrations live on the resolved driver
    // instance, not the manager, so switching the default driver here doesn't move
    // them. Re-requiring the file (harmless — it only contains Broadcast::channel()
    // calls, no declarations) re-registers the closures against the newly-resolved
    // "pusher" driver instance.
    require base_path('routes/channels.php');
});

it('authorizes a campaign member with view access to join the map presence channel, returning the correct shape', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->postJson('/broadcasting/auth', [
        'channel_name' => 'presence-map.' . $map->id,
        'socket_id' => '1234.1234',
    ])->assertStatus(200);

    // Pusher's presence-channel auth response nests the payload our channel
    // closure returned under channel_data.user_info (with a separate top-level
    // user_id), rather than returning it flat — this is the Pusher/Reverb
    // presence-auth wire format, not something our closure controls.
    $channelData = json_decode($response->json('channel_data'), true);
    expect($channelData['user_id'])->toBe((string) auth()->id());
    expect($channelData['user_info']['id'])->toBe(auth()->id());
    expect($channelData['user_info']['name'])->toBe(auth()->user()->name);
    expect($channelData['user_info']['role'])->toBe('edit');
});

it('denies a user who is not a member of the map\'s campaign', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $outsider = User::factory()->create();
    $this->actingAs($outsider);

    $this->postJson('/broadcasting/auth', [
        'channel_name' => 'presence-map.' . $map->id,
        'socket_id' => '1234.1234',
    ])->assertStatus(403);
});

it('authorizes a campaign editor to join the map admin channel', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->postJson('/broadcasting/auth', [
        'channel_name' => 'private-map.' . $map->id . '.admin',
        'socket_id' => '1234.1234',
    ])->assertStatus(200);
});

it('denies a player from joining the map admin channel', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->asPlayer();

    $this->postJson('/broadcasting/auth', [
        'channel_name' => 'private-map.' . $map->id . '.admin',
        'socket_id' => '1234.1234',
    ])->assertStatus(403);
});

it('denies a user who is not a member of the map\'s campaign from the admin channel', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $outsider = User::factory()->create();
    $this->actingAs($outsider);

    $this->postJson('/broadcasting/auth', [
        'channel_name' => 'private-map.' . $map->id . '.admin',
        'socket_id' => '1234.1234',
    ])->assertStatus(403);
});
