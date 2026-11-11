<?php

use App\Enums\AttributeType;
use App\Enums\CampaignVisibility;
use App\Enums\Visibility;
use App\Http\Middleware\ReplicationSwitcher;
use App\Models\Attribute;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\Creature;
use App\Models\Item;
use App\Models\Post;

beforeEach(function () {
    $this->asUser()->withCampaign();
});

function mobileReaderDocument(string $html): DOMXPath
{
    $document = new DOMDocument;
    $document->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING);

    return new DOMXPath($document);
}

it('retains server rendered stories posts and a single reference sidebar', function () {
    $character = Character::factory()->create([
        'campaign_id' => 1,
        'age' => 'Forty winters',
    ]);
    $entity = $character->entity;
    $entity->update(['entry' => '<h2>Early years</h2><p>A server rendered story.</p>']);
    $post = Post::factory()->create([
        'entity_id' => $entity->id,
        'name' => 'Travel journal',
        'entry' => '<p>A server rendered post.</p>',
        'visibility_id' => Visibility::All,
    ]);

    $response = $this->get(route('entities.show', [1, $entity]))
        ->assertSuccessful()
        ->assertSee('A server rendered story.')
        ->assertSee('A server rendered post.')
        ->assertSee('Forty winters');
    $document = mobileReaderDocument($response->getContent());

    expect($document->query('//*[@id="entity-entry-' . $entity->id . '"]')->length)->toBe(1)
        ->and($document->query('//*[@id="post-' . $post->id . '"]')->length)->toBe(1)
        ->and($document->query('//*[@id="entity-details-' . $entity->id . '"]')->length)->toBe(1)
        ->and($document->query('//*[@data-reader-details-content]//*[@id="sidebar-profile-elements"]')->length)->toBe(1)
        ->and($document->query('//*[@data-reader-details-content]//button[@aria-controls="sidebar-profile-elements"][@aria-expanded="true"]')->length)->toBe(1)
        ->and($document->query('//*[@data-reader-details-content]//*[contains(@class, "entity-history")]')->length)->toBe(1)
        ->and($document->query('//*[@id="sidebar-history"]')->length)->toBe(1)
        ->and($document->query('//nav[@id="sm-a"]//a[@href="#entity-details-' . $entity->id . '"]')->length)->toBe(1)
        ->and($document->query('//nav[@id="sm-a"]//select')->length)->toBe(0);

    $sections = $document->query('//*[@data-reader-details-content]/*');
    expect($sections->item(0)->getAttribute('class'))->toContain('entity-pins')
        ->and($sections->item(1)->getAttribute('class'))->toContain('sidebar-section-profile')
        ->and($sections->item(2)->getAttribute('class'))->toContain('entity-history');
});

it('uses existing destinations and preserves modal navigation in More', function () {
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;

    $response = $this->get(route('entities.show', [1, $entity]))->assertSuccessful();
    $document = mobileReaderDocument($response->getContent());
    $campaign = Campaign::findOrFail(1);
    $story = route('entities.show', [$campaign, $entity]);
    $relations = route('entities.relations.index', [$campaign, $entity]);
    $permissions = route('entities.permissions', [$campaign, $entity]);

    expect($document->query('//nav[@id="sm-a"]/a[@href="' . $story . '"][@aria-current="page"]')->length)->toBe(1)
        ->and($document->query('//nav[@id="sm-a"]/a[@href="' . $relations . '"]')->length)->toBe(1)
        ->and($document->query('//nav[@id="sm-a"]//details//a[@href="' . $permissions . '"][@data-toggle="dialog"]')->length)->toBe(1);
});

it('keeps private attributes out of the mobile menu and reference content for readers', function () {
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $entity->update(['is_attributes_private' => true]);
    Attribute::create([
        'entity_id' => $entity->id,
        'name' => 'Hidden attribute',
        'value' => 'Secret reference value',
        'type_id' => AttributeType::Standard,
        'is_pinned' => true,
    ]);
    $this->asPlayer();

    $response = $this->get(route('entities.show', [1, $entity]))
        ->assertSuccessful()
        ->assertDontSee('Secret reference value');
    $document = mobileReaderDocument($response->getContent());

    expect($document->query('//nav[@id="sm-a"]//a[@href="' . route('entities.attributes', [Campaign::findOrFail(1), $entity]) . '"]')->length)->toBe(0)
        ->and($document->query('//nav[@id="sm-a"]//a[@href="' . route('entities.permissions', [Campaign::findOrFail(1), $entity]) . '"]')->length)->toBe(0);
});

it('retains attribute access in the menu and pins for administrators', function () {
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $entity->update(['is_attributes_private' => true]);
    Attribute::create([
        'entity_id' => $entity->id,
        'name' => 'Admin attribute',
        'value' => 'Admin reference value',
        'type_id' => AttributeType::Standard,
        'is_pinned' => true,
    ]);

    $response = $this->get(route('entities.show', [1, $entity]))
        ->assertSuccessful()
        ->assertSee('Admin reference value');
    $document = mobileReaderDocument($response->getContent());

    expect($document->query('//nav[@id="sm-a"]//a[@href="' . route('entities.attributes', [Campaign::findOrFail(1), $entity]) . '"]')->length)->toBe(1);
});

it('marks the current secondary destination without offering an unavailable details sidebar', function () {
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;

    $response = $this->get(route('entities.attributes', [1, $entity]))->assertSuccessful();
    $document = mobileReaderDocument($response->getContent());

    expect($document->query('//nav[@id="sm-a"]//summary[@aria-current="true"]')->length)->toBe(1)
        ->and($document->query('//nav[@id="sm-a"]//a[@href="' . route('entities.attributes', [Campaign::findOrFail(1), $entity]) . '"][@aria-current="page"]')->length)->toBe(1)
        ->and($document->query('//*[@data-reader-details-link]')->length)->toBe(0);
});

it('omits mobile enhancements from the printable submenu', function () {
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;

    $this->blade('<x-entities.submenu :entity="$entity" :campaign="$campaign" active="story" :printing="true" />', [
        'entity' => $entity,
        'campaign' => Campaign::findOrFail(1),
    ])->assertDontSee('js-entity-reader')
        ->assertDontSee('entity-mobile-navigation');
});

it('retains public attribute navigation for guests without exposing restricted posts', function () {
    $campaign = Campaign::findOrFail(1);
    $campaign->update(['visibility_id' => CampaignVisibility::public]);
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    Post::factory()->create([
        'entity_id' => $entity->id,
        'name' => 'A public post',
        'visibility_id' => Visibility::All,
    ]);
    Post::factory()->create([
        'entity_id' => $entity->id,
        'name' => 'An admin only post',
        'visibility_id' => Visibility::Admin,
    ]);
    auth()->guard('api')->forgetUser();
    $this->withoutMiddleware(ReplicationSwitcher::class);

    $response = $this->get(route('entities.show', [$campaign, $entity]))
        ->assertSuccessful()
        ->assertSee('A public post')
        ->assertDontSee('An admin only post');
    $document = mobileReaderDocument($response->getContent());

    expect($document->query('//nav[@id="sm-a"]//a[@href="' . route('entities.attributes', [$campaign, $entity]) . '"]')->length)->toBe(1);
});

it('keeps the full reference profile in the printable entity page', function () {
    $entity = Character::factory()->create(['campaign_id' => 1, 'age' => 'Forty winters'])->entity;

    $this->get(route('entities.html-export', [1, $entity]))
        ->assertSuccessful()
        ->assertSee('Forty winters')
        ->assertDontSee('js-entity-reader')
        ->assertDontSee('entity-mobile-navigation');
});

it('retains reader navigation and entries on type specific story layouts', function (string $model) {
    $entity = $model::factory()->create(['campaign_id' => 1])->entity;
    $entity->update(['entry' => '<h2>Background</h2><p>A category specific story.</p>']);

    $response = $this->get(route('entities.show', [1, $entity]))
        ->assertSuccessful()
        ->assertSee('A category specific story.');
    $document = mobileReaderDocument($response->getContent());

    expect($document->query('//nav[@id="sm-a"]//*[@data-entity-id="' . $entity->id . '"]')->length)->toBe(1)
        ->and($document->query('//*[contains(@class, "entity-main-block")]//*[@id="entity-entry-' . $entity->id . '"]')->length)->toBe(1);
})->with([
    'items' => [Item::class],
    'creatures' => [Creature::class],
]);
