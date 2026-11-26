<?php

use App\Http\Middleware\ReplicationSwitcher;
use App\Models\Campaign;
use App\Models\CampaignInvite;
use App\Models\User;

it('shows an inactive token error when an authenticated user joins an invite for a soft-deleted campaign', function () {
    $this->asUser()->withCampaign();

    $user = auth()->user();
    $campaign = Campaign::firstOrFail();

    $invite = CampaignInvite::create([
        'campaign_id' => $campaign->id,
        'created_by' => $user->id,
    ]);

    $campaign->delete();

    $this->get(route('campaigns.join', $invite->token))
        ->assertRedirect(route('start'))
        ->assertSessionHas('error', __('campaigns.invites.error.inactive_token'));
});

it('shows an inactive token error when a guest joins an invite for a soft-deleted campaign', function () {
    $this->withoutMiddleware(ReplicationSwitcher::class);

    $user = User::factory()->create();
    $campaign = Campaign::factory()->create();

    $invite = CampaignInvite::create([
        'campaign_id' => $campaign->id,
        'created_by' => $user->id,
    ]);

    $campaign->delete();

    $this->get(route('campaigns.join', $invite->token))
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors();

    expect(session('errors')->all())->toContain(__('campaigns.invites.error.inactive_token'));
});
