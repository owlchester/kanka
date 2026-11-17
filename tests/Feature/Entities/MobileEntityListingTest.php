<?php

use App\Enums\CampaignVisibility;
use App\Http\Middleware\ReplicationSwitcher;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\EntityType;
use Illuminate\Support\Facades\Auth;

it('renders account navigation without adding an extra world breadcrumb', function () {
    $this->asUser()->withCampaign();
    $campaign = Campaign::firstOrFail();
    $entityType = EntityType::findOrFail(config('entities.ids.character'));

    $this->get(route('entities.index', [1, $entityType]))
        ->assertSuccessful()
        ->assertSee('campaigns_label="' . __('entities.campaigns') . '"', false)
        ->assertSee('close_label="' . __('crud.actions.close') . '"', false)
        ->assertSee(__('maps.actions.explore'))
        ->assertSee(__('crud.search'))
        ->assertSee(__('sidebar.entity-creator'))
        ->assertSee(__('mobile.account.switch_world'))
        ->assertSee(__('settings.menu.account'))
        ->assertDontSee('mobile-world-context', false)
        ->assertSee('account-api="' . route('layout.navigation') . '"', false)
        ->assertSee('quick-create-url="' . route('entity-creator.selection', $campaign) . '"', false);
});

it('offers guest authentication without exposing account or creation controls', function (bool $registrationEnabled) {
    config(['auth.register_enabled' => $registrationEnabled]);
    $this->asUser()->withCampaign(['visibility_id' => CampaignVisibility::public->value]);
    Auth::forgetGuards();
    Auth::shouldUse('web');
    $this->withoutMiddleware(ReplicationSwitcher::class);
    $entityType = EntityType::findOrFail(config('entities.ids.character'));

    $response = $this->get(route('entities.index', [1, $entityType]));

    $response->assertSuccessful()
        ->assertSee(':authenticated="false"', false)
        ->assertSee('login-url="', false)
        ->assertDontSee('account-api="', false)
        ->assertDontSee('quick-create-url="', false);

    if ($registrationEnabled) {
        $response->assertSee('register-url="', false);
    } else {
        $response->assertDontSee('register-url="', false);
    }
})->with([true, false]);

it('provides profile settings and documentation links in account navigation', function () {
    $this->asUser()->withCampaign();

    $this->getJson(route('layout.navigation'))
        ->assertSuccessful()
        ->assertJsonPath('profile.urls.settings.url', route('settings.profile'))
        ->assertJsonPath('profile.urls.help.name', __('footer.documentation'))
        ->assertJsonPath('profile.urls.help.url', 'https://docs.kanka.io/en/latest');
});

it('returns the saved name filter and mobile list labels', function () {
    $this->asUser()->withCampaign();
    $entityType = EntityType::findOrFail(config('entities.ids.character'));
    $character = Character::factory()->create(['campaign_id' => 1, 'name' => 'Mira']);

    $this->getJson(route('entities.index-api', [1, $entityType, 'name' => 'Mira', '_clean' => 1]))
        ->assertSuccessful()
        ->assertJsonPath('filters.name', 'Mira')
        ->assertJsonPath('i18n.findInList', __('search.lookup.hint_name'))
        ->assertJsonPath('i18n.listSettings', __('datagrids.display.title'))
        ->assertJsonPath('i18n.fromTemplate', __('entities.creator.modes.archetypes'))
        ->assertJsonPath('i18n.filterSort', __('mobile.lists.filter_sort'))
        ->assertJsonPath('i18n.close', __('crud.actions.close'))
        ->assertJsonPath('entities.data.0.id', $character->entity->id)
        ->assertJsonPath('entities.data.0.can_edit', true);

    $this->getJson(route('entities.index-api', [1, $entityType]))
        ->assertSuccessful()
        ->assertJsonPath('filters.name', 'Mira');
});

it('keeps events and posts available through the quick creator', function () {
    $this->asUser()->withCampaign();
    $campaign = Campaign::firstOrFail();

    $this->get(route('entity-creator.selection', $campaign))
        ->assertSuccessful()
        ->assertSee('data-dialog-back', false)
        ->assertSee(route('entity-creator.form', [$campaign, config('entities.ids.event')]), false)
        ->assertSee('data-entity-type="post"', false)
        ->assertSee(route('entity-creator.post', $campaign), false);
});

it('offers a mobile back action from a quick creation form to the type chooser', function () {
    $this->asUser()->withCampaign();
    $campaign = Campaign::firstOrFail();

    $this->get(route('entity-creator.form', [$campaign, config('entities.ids.character')]))
        ->assertSuccessful()
        ->assertSee('data-toggle="entity-creator" data-url="' . route('entity-creator.selection', $campaign) . '"', false)
        ->assertSee(__('crud.actions.back'));
});

it('offers sorting in the filter sheet without losing entity specific sort preferences', function () {
    $this->asUser()->withCampaign();
    $entityType = EntityType::findOrFail(config('entities.ids.character'));

    $this->getJson(route('entities.index-api', [1, $entityType, 'order' => 'title', 'desc' => 1]))
        ->assertSuccessful()
        ->assertJsonPath('order.title', 'desc');

    $this->get(route('filters.form', [1, $entityType]))
        ->assertSuccessful()
        ->assertSee(__('mobile.lists.filter_sort'))
        ->assertSee('name="order"', false)
        ->assertSee('value="title" selected', false)
        ->assertSee('value="1" selected', false);

    $this->getJson(route('entities.index-api', [1, $entityType]))
        ->assertSuccessful()
        ->assertJsonPath('order.title', 'desc');
});
