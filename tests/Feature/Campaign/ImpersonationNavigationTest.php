<?php

use App\Facades\Identity;
use App\Models\Campaign;
use App\Models\CampaignRole;
use App\Models\CampaignRoleUser;
use App\Models\User;

it('moves the active identity and return link into desktop and mobile account navigation', function () {
    $this->withoutVite()->asUser()->withCampaign()->withMember();
    $owner = auth()->user();
    $campaign = Campaign::firstOrFail();
    $member = User::whereKeyNot($owner->id)->firstOrFail();
    $member->update(['name' => 'Mira O\'Connor']);
    $otherCampaign = Campaign::factory()->create();
    foreach ([$campaign->id => 'Cartographer', $otherCampaign->id => 'Other campaign role'] as $campaignId => $name) {
        $role = CampaignRole::create(['campaign_id' => $campaignId, 'name' => $name]);
        CampaignRoleUser::create(['campaign_role_id' => $role->id, 'user_id' => $member->id]);
    }
    $dashboard = route('dashboard', $campaign);
    $returnUrl = route('identity.back', $campaign);

    $response = $this->actingAs($member, 'web')->withSession([
        Identity::getSessionKey() => $owner->id,
        Identity::getSessionCampaignKey() => $campaign->id,
    ])->get($dashboard)->assertSuccessful();

    $document = new DOMDocument;
    $document->loadHTML($response->getContent(), LIBXML_NOERROR | LIBXML_NOWARNING);

    foreach (['nav-switcher', 'mobile-navigation'] as $tag) {
        $binding = $document->getElementsByTagName($tag)->item(0)->getAttribute(':impersonation');
        $impersonation = json_decode($binding, true, flags: JSON_THROW_ON_ERROR);

        expect($impersonation)
            ->label->toBe('Acting as Mira O\'Connor')
            ->shortLabel->toBe('Acting as…')
            ->returnLabel->toBe('Back to my account')
            ->returnUrl->toBe($returnUrl)
            ->roles->toBe(['Player', 'Cartographer']);
    }

    $response->assertDontSee('You are viewing and interacting with');

    $this->get($returnUrl)->assertRedirect($dashboard)->assertSessionMissing(Identity::getSessionKey());
    $this->assertAuthenticatedAs($owner, 'web');
    $this->get($dashboard)->assertSuccessful()->assertDontSee(':impersonation=', false);
});
