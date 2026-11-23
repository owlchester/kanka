<?php

use App\Facades\Identity;
use App\Models\Character;
use App\Models\EntityType;

function setUserCreatedAt(string $timestamp, ?string $layout = null): void
{
    $user = auth()->user();
    $user->created_at = $timestamp;
    if ($layout !== null) {
        $user->saveSettings(['entry_form_layout' => $layout]);
    }
    $user->saveQuietly();
}

describe('v4 dashboard welcome banner', function () {
    it('shows the welcome banner for users created before the cutoff', function () {
        $this->asUser()->withCampaign();
        setUserCreatedAt('2026-11-23 23:59:59');

        $this->get(route('dashboard', [1]))
            ->assertSuccessful()
            ->assertSee('id="v4-dashboard-welcome"', false);
    });

    it('hides the welcome banner for users created on or after the cutoff', function () {
        $this->asUser()->withCampaign();
        setUserCreatedAt('2026-11-24 00:00:00');

        $this->get(route('dashboard', [1]))
            ->assertSuccessful()
            ->assertDontSee('id="v4-dashboard-welcome"', false);
    });

    it('hides the welcome banner when impersonating', function () {
        $this->asUser()->withCampaign();
        setUserCreatedAt('2026-11-23 23:59:59');
        Identity::shouldReceive('isImpersonating')->andReturn(true);
        Identity::shouldReceive('getCampaignId')->andReturn(1);
        Identity::shouldReceive('campaignRoleNames')->andReturn([]);

        $this->get(route('dashboard', [1]))
            ->assertSuccessful()
            ->assertDontSee('id="v4-dashboard-welcome"', false);
    });

    it('persists dismissal of the welcome banner', function () {
        $this->asUser()->withCampaign();
        setUserCreatedAt('2026-11-23 23:59:59');

        $this->post(route('tutorials.dismiss', ['code' => 'v4_dashboard_welcome']))
            ->assertSuccessful();

        expect(auth()->user()->tutorials()->where('code', 'v4_dashboard_welcome')->exists())->toBeTrue();

        $this->get(route('dashboard', [1]))
            ->assertSuccessful()
            ->assertDontSee('id="v4-dashboard-welcome"', false);
    });
});

describe('v4 entry form layout prompt', function () {
    it('shows the prompt on create and edit forms for legacy pre-cutoff users', function () {
        $this->asUser()->withCampaign(['boost_count' => 4]);
        setUserCreatedAt('2026-11-23 23:59:59', 'legacy');

        $customType = new EntityType(['code' => 'gadget', 'is_special' => true, 'is_enabled' => true]);
        $customType->campaign_id = 1;
        $customType->singular = 'Gadget';
        $customType->plural = 'Gadgets';
        $customType->icon = 'fa-solid fa-gear';
        $customType->save();
        $character = Character::factory()->create(['campaign_id' => 1]);

        $this->get(route('characters.create', [1]))
            ->assertSuccessful()
            ->assertSee('id="v4-entry-layout-prompt"', false);

        $this->get(route('entities.create', [1, $customType]))
            ->assertSuccessful()
            ->assertSee('id="v4-entry-layout-prompt"', false);

        $this->get(route('entities.edit', [1, $character->entity]))
            ->assertSuccessful()
            ->assertSee('id="v4-entry-layout-prompt"', false);
    });

    it('hides the prompt for post-cutoff users', function () {
        $this->asUser()->withCampaign();
        setUserCreatedAt('2026-11-24 00:00:00', 'legacy');

        $this->get(route('characters.create', [1]))
            ->assertSuccessful()
            ->assertDontSee('id="v4-entry-layout-prompt"', false);
    });

    it('hides the prompt when already using the modern layout', function () {
        $this->asUser()->withCampaign();
        setUserCreatedAt('2026-11-23 23:59:59', 'modern');

        $this->get(route('characters.create', [1]))
            ->assertSuccessful()
            ->assertDontSee('id="v4-entry-layout-prompt"', false);
    });

    it('hides the prompt on ajax requests', function () {
        $this->asUser()->withCampaign();
        setUserCreatedAt('2026-11-23 23:59:59', 'legacy');

        $this->withHeaders(['X-Requested-With' => 'XMLHttpRequest'])
            ->get(route('characters.create', [1]))
            ->assertSuccessful()
            ->assertDontSee('id="v4-entry-layout-prompt"', false);
    });

    it('hides the prompt after dismissal', function () {
        $this->asUser()->withCampaign();
        setUserCreatedAt('2026-11-23 23:59:59', 'legacy');

        $this->post(route('tutorials.dismiss', ['code' => 'v4_entry_form_layout']))
            ->assertSuccessful();

        $this->get(route('characters.create', [1]))
            ->assertSuccessful()
            ->assertDontSee('id="v4-entry-layout-prompt"', false);
    });

    it('enables modern entry form layout and dismisses the prompt', function () {
        $this->asUser()->withCampaign();
        setUserCreatedAt('2026-11-23 23:59:59', 'legacy');
        auth()->user()->saveSettings(['editor' => 'tiptap'])->save();

        $this->post(route('settings.appearance.modern-entry-form'))
            ->assertSuccessful()
            ->assertJson(['success' => true]);

        $user = auth()->user()->fresh();
        expect($user->entry_form_layout)->toBe('modern')
            ->and($user->editor)->toBe('tiptap')
            ->and($user->tutorials()->where('code', 'v4_entry_form_layout')->exists())->toBeTrue();

        $this->get(route('characters.create', [1]))
            ->assertSuccessful()
            ->assertSee('entry-workspace', false)
            ->assertDontSee('id="v4-entry-layout-prompt"', false);
    });
});
