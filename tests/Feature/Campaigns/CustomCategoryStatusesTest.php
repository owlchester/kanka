<?php

use App\Datagrids\Bulks\EntityBulk;
use App\Facades\ImportIdMapper;
use App\Models\Bookmark;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use App\Models\CategoryStatus;
use App\Models\Entity;
use App\Models\EntityType;
use App\Services\BulkService;
use App\Services\Campaign\ExportService;
use App\Services\Campaign\Import\ImportService;
use App\Services\Campaign\Import\Mappers\CustomMapper;
use App\Services\Entity\MoveService;
use App\Services\Entity\TransformService;
use Database\Seeders\CategoryStatusSeeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\ComponentAttributeBag;

function statusCategory(int $campaignId = 1): EntityType
{
    $category = new EntityType(['code' => 'mystery', 'is_special' => true, 'is_enabled' => true]);
    $category->campaign_id = $campaignId;
    $category->singular = 'Mystery';
    $category->plural = 'Mysteries';
    $category->icon = 'fa-solid fa-question';
    $category->save();

    return $category;
}

function statusEntry(EntityType $category, array $data = []): Entity
{
    $entity = new Entity($data + ['campaign_id' => $category->campaign_id, 'name' => 'A mystery']);
    $entity->type_id = $category->id;
    $entity->save();

    return $entity;
}

beforeEach(function () {
    $this->asUser()->withCampaign(['boost_count' => 4]);
    $this->campaign = Campaign::findOrFail(1);
    $this->category = statusCategory();
    $this->url = "/api/1.0/campaigns/1/entity_types/{$this->category->id}/statuses";
});

it('creates custom statuses with labels optional icons stable keys and reserved identifiers', function () {
    $created = $this->postJson($this->url, ['label' => 'Unexplored', 'is_default' => true])
        ->assertCreated()->assertJsonPath('data.name', 'Unexplored')->assertJsonPath('data.icon', '');
    $id = $created->json('data.id');
    expect($id)->toBeGreaterThanOrEqual(1000);

    $this->patchJson($this->url . '/' . $id, ['label' => 'Investigating', 'icon' => 'fa-solid fa-magnifying-glass'])
        ->assertOk()->assertJsonPath('data.key', 'unexplored')->assertJsonPath('data.name', 'Investigating')->assertJsonPath('data.is_default', true);

    $this->getJson($this->url)->assertOk()->assertJsonCount(1, 'data');
});

it('limits categories to ten unique nonempty status labels', function () {
    foreach (range(1, 10) as $number) {
        $this->postJson($this->url, ['label' => 'Status ' . $number])->assertCreated();
    }
    $this->postJson($this->url, ['label' => 'Too many'])->assertUnprocessable();
    $this->patchJson($this->url . '/' . $this->category->statuses()->first()->id, ['label' => 'status 2'])->assertUnprocessable();
    $this->postJson($this->url, ['label' => '   '])->assertUnprocessable();
    $this->postJson($this->url, ['label' => 'Unsafe', 'icon' => '<script>alert(1)</script>'])->assertUnprocessable();
});

it('reorders statuses and maintains exactly one optional default', function () {
    $first = $this->postJson($this->url, ['label' => 'First', 'is_default' => true])->json('data.id');
    $second = $this->postJson($this->url, ['label' => 'Second', 'is_default' => true])->json('data.id');
    expect(CategoryStatus::find($first)->is_default)->toBeFalse()->and(CategoryStatus::find($second)->is_default)->toBeTrue();
    $this->putJson($this->url . '/order', ['ids' => [$second, $first]])->assertOk()->assertJsonPath('data.0.id', $second);
    $this->putJson($this->url . '/order', ['ids' => [$first, $first]])->assertUnprocessable();
    $this->putJson($this->url . '/order', ['ids' => [$first]])->assertUnprocessable();
    $this->patchJson($this->url . '/' . $second, ['label' => 'Second', 'is_default' => false])->assertOk();
    expect($this->category->statuses()->where('is_default', true)->count())->toBe(0);
});

it('rejects definition writes outside premium custom category settings access', function () {
    $standard = EntityType::default()->firstOrFail();
    $this->postJson("/api/1.0/campaigns/1/entity_types/{$standard->id}/statuses", ['label' => 'No'])->assertNotFound();
    $other = Campaign::factory()->create(['boost_count' => 4]);
    $foreign = statusCategory($other->id);
    $this->postJson("/api/1.0/campaigns/1/entity_types/{$foreign->id}/statuses", ['label' => 'No'])->assertNotFound();
    $this->campaign->forceFill(['boost_count' => 0])->save();
    $this->postJson($this->url, ['label' => 'No'])->assertForbidden();
    $this->campaign->forceFill(['boost_count' => 4])->save();
    $this->asPlayer();
    $this->postJson($this->url, ['label' => 'No'])->assertForbidden();
});

it('applies creation defaults but preserves explicit empty assignments and omitted updates', function () {
    $id = $this->postJson($this->url, ['label' => 'Unexplored', 'is_default' => true])->json('data.id');
    $entityUrl = "/api/1.0/campaigns/1/entities/{$this->category->id}";
    $created = $this->postJson($entityUrl, ['entities' => [['name' => 'Default'], ['name' => 'Empty', 'status_id' => null]]])
        ->assertOk()->assertJsonPath('data.0.status_id', $id)->assertJsonPath('data.1.status_id', null);
    $entity = $created->json('data.0.id');
    $this->patchJson('/api/1.0/campaigns/1/entities/' . $entity, ['name' => 'Renamed'])->assertOk()->assertJsonPath('data.status_id', $id);
    $this->patchJson('/api/1.0/campaigns/1/entities/' . $entity, ['status_id' => null])->assertOk()->assertJsonPath('data.status_id', null);
    $this->postJson($this->url, ['label' => 'Another default', 'is_default' => true])->assertCreated();
    expect(Entity::find($entity)->status_id)->toBeNull();
});

it('validates assignments against the category and campaign', function () {
    $id = $this->postJson($this->url, ['label' => 'Unexplored'])->json('data.id');
    $otherCategory = statusCategory();
    $entity = statusEntry($otherCategory);
    $this->patchJson('/api/1.0/campaigns/1/entities/' . $entity->id, ['status_id' => $id])->assertUnprocessable();
    $this->postJson("/api/1.0/campaigns/1/entities/{$otherCategory->id}", ['entities' => [['name' => 'Wrong', 'status_id' => $id]]])->assertUnprocessable();
    $this->post(route('entities.store', [1, $otherCategory]), ['name' => 'Wrong', 'status_id' => $id])->assertSessionHasErrors('status_id');
    expect($entity->refresh()->status_id)->toBeNull();
});

it('preserves assignments on downgrade while allowing clearing but not new assignments', function () {
    $id = $this->postJson($this->url, ['label' => 'First'])->json('data.id');
    $other = $this->postJson($this->url, ['label' => 'Second'])->json('data.id');
    $entity = statusEntry($this->category, ['status_id' => $id]);
    $this->campaign->forceFill(['boost_count' => 0])->save();
    $path = '/api/1.0/campaigns/1/entities/' . $entity->id;
    $this->getJson($this->url)->assertOk()->assertJsonCount(2, 'data');
    $this->patchJson($path, ['name' => 'Still editable'])->assertOk()->assertJsonPath('data.status_id', $id);
    $this->patchJson($path, ['status_id' => $id])->assertOk();
    $this->patchJson($path, ['status_id' => $other])->assertUnprocessable();
    $this->patchJson($path, ['status_id' => null])->assertOk()->assertJsonPath('data.status_id', null);
    $this->patchJson($path, ['status_id' => $id])->assertUnprocessable();
});

it('replaces assignments including deleted entries without touching recent timestamps', function () {
    $id = $this->postJson($this->url, ['label' => 'First', 'is_default' => true])->json('data.id');
    $replacement = $this->postJson($this->url, ['label' => 'Second'])->json('data.id');
    $entity = statusEntry($this->category, ['status_id' => $id]);
    $deleted = statusEntry($this->category, ['status_id' => $id]);
    $deleted->delete();
    $timestamp = $entity->updated_at->toDateTimeString();
    $this->deleteJson($this->url . '/' . $id)->assertUnprocessable();
    $this->deleteJson($this->url . '/' . $id, ['replacement_id' => $id])->assertUnprocessable();
    $this->deleteJson($this->url . '/' . $id, ['replacement_id' => $replacement])->assertNoContent();
    expect($entity->refresh()->status_id)->toBe($replacement)
        ->and($entity->updated_at->toDateTimeString())->toBe($timestamp)
        ->and($deleted->refresh()->status_id)->toBe($replacement)
        ->and(CategoryStatus::find($replacement)->is_default)->toBeTrue();
});

it('replaces saved filters or leaves them safely nonmatching after clearing', function () {
    $id = $this->postJson($this->url, ['label' => 'First'])->json('data.id');
    $replacement = $this->postJson($this->url, ['label' => 'Second'])->json('data.id');
    $bookmark = new Bookmark(['name' => 'Filtered', 'filters' => 'status_id=' . $id]);
    $bookmark->campaign_id = 1;
    $bookmark->entity_type_id = $this->category->id;
    $bookmark->save();
    $widget = new CampaignDashboardWidget;
    $widget->campaign_id = 1;
    $widget->widget = 'recent';
    $widget->entity_type_id = $this->category->id;
    $widget->config = ['filters' => http_build_query(['status_id' => [$id]])];
    $widget->save();
    statusEntry($this->category, ['status_id' => $id]);
    $this->deleteJson($this->url . '/' . $id, ['replacement_id' => $replacement])->assertNoContent();
    expect($bookmark->refresh()->filters)->toBe('status_id=' . $replacement);
    $this->deleteJson($this->url . '/' . $replacement, ['clear' => true])->assertNoContent();
    parse_str($bookmark->refresh()->filters, $filters);
    expect($filters['status_id'])->toBe('deleted:' . $replacement)
        ->and(Entity::inTypes($this->category->id)->filter($filters)->count())->toBe(0);
    parse_str($widget->refresh()->config['filters'], $widgetFilters);
    expect(Entity::inTypes($this->category->id)->filter($widgetFilters)->count())->toBe(0);
});

it('renders full page category forms and saves initial definitions atomically', function () {
    $this->get(route('entity_types.create', 1))->assertOk()->assertSee('data-category-form', false)->assertSee('category-statuses')->assertSee('category-image')->assertDontSee('aria-label="Category settings"', false);
    $this->get(route('entity_types.edit', [1, $this->category]))->assertOk()->assertSee('category-general');
    $this->post(route('entity_types.store', 1), [
        'singular' => 'Clue', 'plural' => 'Clues', 'icon' => 'fa-solid fa-key', 'is_enabled' => 1,
        'statuses' => [['label' => 'Found', 'is_default' => true]],
    ])->assertRedirect();
    $category = EntityType::where('singular', 'Clue')->firstOrFail();
    expect($category->statuses()->first()->name())->toBe('Found');
    $this->post(route('entity_types.store', 1), [
        'singular' => 'Invalid', 'plural' => 'Invalid', 'icon' => 'fa-solid fa-key', 'is_enabled' => 1,
        'statuses' => [['label' => 'Same'], ['label' => 'same']],
    ])->assertSessionHasErrors('statuses');
    expect(EntityType::where('singular', 'Invalid')->exists())->toBeFalse();
});

it('does not implicitly delete definitions omitted from the category editor', function () {
    $id = $this->postJson($this->url, ['label' => 'Keep'])->json('data.id');
    $this->patch(route('entity_types.update', [1, $this->category]), [
        'singular' => 'Changed', 'plural' => 'Mysteries', 'icon' => 'fa-solid fa-question', 'is_enabled' => 1,
        'statuses_present' => 1,
    ])->assertSessionHasErrors('statuses');
    expect(CategoryStatus::find($id))->not->toBeNull()->and($this->category->refresh()->singular)->toBe('Mystery');
});

it('filters statuses and explicitly unassigned entries', function () {
    $id = $this->postJson($this->url, ['label' => 'First'])->json('data.id');
    $assigned = statusEntry($this->category, ['status_id' => $id]);
    $empty = statusEntry($this->category, ['status_id' => null]);
    expect(Entity::inTypes($this->category->id)->filter(['status_id' => $id])->pluck('id')->all())->toBe([$assigned->id])
        ->and(Entity::inTypes($this->category->id)->filter(['status_id' => 'none'])->pluck('id')->all())->toBe([$empty->id]);
    $url = '/api/1.0/campaigns/1/entities?type_id=' . $this->category->id . '&';
    $this->getJson($url . http_build_query(['status_id' => $id]))->assertOk()->assertJsonCount(1, 'data')->assertJsonPath('data.0.id', $assigned->id);
    $this->getJson($url . 'status_id=none')->assertOk()->assertJsonCount(1, 'data')->assertJsonPath('data.0.id', $empty->id);
    $this->getJson($url . http_build_query(['status_id' => [$id, 'none']]))->assertOk()->assertJsonCount(2, 'data');
    $this->getJson($url . 'status_id=deleted%3A1000')->assertOk()->assertJsonCount(0, 'data');
});

it('seeds built in statuses below 1000 without consuming the custom range', function () {
    $this->seed(CategoryStatusSeeder::class);
    $ids = CategoryStatus::whereNull('campaign_id')->pluck('id')->all();
    expect(max($ids))->toBeLessThan(1000);
    $this->seed(CategoryStatusSeeder::class);
    expect(CategoryStatus::whereNull('campaign_id')->count())->toBe(count($ids));
    $this->postJson($this->url, ['label' => 'Custom'])->assertCreated();
    expect($this->category->statuses()->first()->id)->toBeGreaterThanOrEqual(1000);
});

it('saves status ordering and the unchanged default through the category editor', function () {
    $first = $this->postJson($this->url, ['label' => 'First', 'is_default' => true])->json('data.id');
    $second = $this->postJson($this->url, ['label' => 'Second'])->json('data.id');
    $this->patch(route('entity_types.update', [1, $this->category]), [
        'singular' => 'Mystery', 'plural' => 'Mysteries', 'icon' => 'fa-solid fa-question', 'is_enabled' => 1,
        'statuses' => [['id' => $second, 'label' => 'Second'], ['id' => $first, 'label' => 'First renamed', 'is_default' => true]],
    ])->assertRedirect();
    expect($this->category->statuses()->pluck('id')->all())->toBe([$second, $first])
        ->and(CategoryStatus::find($first)->is_default)->toBeTrue();
});

it('supports status assignment and explicit clearing in web forms and bulk editing', function () {
    $id = $this->postJson($this->url, ['label' => 'First', 'is_default' => true])->json('data.id');
    $this->post(route('entities.store', [1, $this->category]), ['name' => 'Web default'])->assertRedirect();
    $entity = Entity::where('name', 'Web default')->firstOrFail();
    expect($entity->status_id)->toBe($id);
    $this->post(route('entities.store', [1, $this->category]), ['name' => 'Web empty', 'status_id' => null])->assertRedirect();
    $empty = Entity::where('name', 'Web empty')->firstOrFail();
    expect($empty->status_id)->toBeNull();

    $bulk = app(BulkService::class)->campaign($this->campaign)->entityType($this->category)->user(auth()->user())->entities([$entity->id, $empty->id]);
    $bulk->editing(['status_id' => 'remove'], new EntityBulk);
    expect($entity->refresh()->status_id)->toBeNull();
    $bulk->editing(['status_id' => (string) $id], new EntityBulk);
    expect($entity->refresh()->status_id)->toBe($id)->and($empty->refresh()->status_id)->toBe($id);

    $foreign = statusEntry(statusCategory());
    $bulk->entities([$entity->id, $foreign->id]);
    expect(fn () => $bulk->editing(['name' => 'Must not change', 'status_id' => 'remove'], new EntityBulk))
        ->toThrow(ValidationException::class);
    expect($entity->refresh()->name)->toBe('Web default')->and($entity->status_id)->toBe($id);
});

it('renders custom labels without icons in listing resources and widget previews', function () {
    $id = $this->postJson($this->url, ['label' => '<Solved>'])->json('data.id');
    $entity = statusEntry($this->category, ['status_id' => $id]);
    $response = $this->getJson(route('entities.index-api', [1, $this->category]));
    $response->assertOk()->assertJsonPath('entities.data.0.status.name', '<Solved>')->assertJsonPath('entities.data.0.status.is_custom', true);
    $html = view('components.entities.status', ['status' => $entity->status, 'compact' => true, 'attributes' => new ComponentAttributeBag])->render();
    expect($html)->toContain('&lt;Solved&gt;')->not->toContain('<Solved>');
    $selector = view('cruds.fields.status', ['campaign' => $this->campaign, 'entityType' => $this->category, 'entity' => $entity])->render();
    expect($selector)->toContain('&lt;Solved&gt;')->not->toContain('<Solved>');
    $this->get(route('entity_types.statuses.confirm', [1, $this->category, $id]))->assertOk()->assertSee('&lt;Solved&gt;', false);
});

it('keeps empty assignments on edit forms even when a default exists', function () {
    $id = $this->postJson($this->url, ['label' => 'Default', 'is_default' => true])->json('data.id');
    $entity = statusEntry($this->category, ['status_id' => null]);
    $html = view('cruds.fields.status', ['campaign' => $this->campaign, 'entityType' => $this->category, 'entity' => $entity])->render();
    $document = new DOMDocument;
    $document->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING);
    expect((new DOMXPath($document))->query('//select[@name="status_id"]/option[@selected]')->item(0)->getAttribute('value'))->toBe('');
});

it('renders icon bearing statuses with a hidden accessible label instead of visible text', function () {
    $id = $this->postJson($this->url, ['label' => 'Investigating', 'icon' => 'fa-solid fa-magnifying-glass'])->json('data.id');
    $html = view('components.entities.status', ['status' => CategoryStatus::findOrFail($id), 'attributes' => new ComponentAttributeBag])->render();
    $document = new DOMDocument;
    $document->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING);
    $xpath = new DOMXPath($document);
    expect($xpath->query('//i[@title="Investigating"]'))->toHaveCount(1)
        ->and($xpath->query('//span[@class="sr-only" and text()="Investigating"]'))->toHaveCount(1);
});

it('round trips status definitions and remaps assignments rather than trusting source ids', function () {
    Storage::fake('local');
    ImportIdMapper::swap(new App\Services\Campaign\Import\ImportIdMapper);
    $id = $this->postJson($this->url, ['label' => 'Original label', 'is_default' => true])->json('data.id');
    $this->patchJson($this->url . '/' . $id, ['label' => 'Renamed label'])->assertOk();

    $archivePath = tempnam(sys_get_temp_dir(), 'status-export-');
    $archive = new ZipArchive;
    $archive->open($archivePath, ZipArchive::OVERWRITE);
    try {
        $export = app(ExportService::class)->campaign($this->campaign);
        (new ReflectionProperty($export, 'archive'))->setValue($export, $archive);
        (new ReflectionMethod($export, 'customCampaignModules'))->invoke($export);
        $archive->close();
        $archive->open($archivePath);
        $json = $archive->getFromName('settings/custom-modules.json');
        $definitions = json_decode($json, true);
        expect($definitions[0]['statuses'][0]['key'])->toBe('original_label')->and($definitions[0]['statuses'][0]['label'])->toBe('Renamed label');

        Storage::disk('local')->put('status-test/settings/custom-modules.json', $json);
        $import = app(ImportService::class)->campaign($this->campaign)->user(auth()->user());
        (new ReflectionProperty($import, 'dataPath'))->setValue($import, 'status-test');
        (new ReflectionMethod($import, 'customModules'))->invoke($import);
        $destination = EntityType::findOrFail(ImportIdMapper::getCustomEntityType($this->category->id));
        $newStatus = $destination->statuses()->firstOrFail();
        expect($newStatus->id)->not->toBe($id)->and($newStatus->key)->toBe('original_label')->and($newStatus->is_default)->toBeTrue();

        $mapper = app(CustomMapper::class)->campaign($this->campaign)->user(auth()->user())->path('status-test');
        $mapper->data(['entity' => ['id' => 987, 'type_id' => $this->category->id, 'name' => 'Imported', 'status_id' => $id]])->first();
        expect(Entity::findOrFail(ImportIdMapper::getEntity(987))->status_id)->toBe($newStatus->id);
        $mapper->data(['entity' => ['id' => 988, 'type_id' => $this->category->id, 'name' => 'Legacy', 'status_id' => 999999]])->first();
        expect(Entity::findOrFail(ImportIdMapper::getEntity(988))->status_id)->toBeNull();
    } finally {
        $archive->close();
        unlink($archivePath);
    }
});

it('does not lower an already advanced status sequence', function () {
    $status = new CategoryStatus(['campaign_id' => 1, 'category_id' => $this->category->id, 'key' => 'large', 'label' => 'Large']);
    $status->id = 5000;
    $status->save();
    $status->delete();
    $migration = require database_path('migrations/2026_11_09_215950_reserve_application_category_status_ids.php');
    $migration->up();
    $widening = require database_path('migrations/2026_11_09_222139_widen_category_status_icons.php');
    $widening->up();
    $this->postJson($this->url, ['label' => 'Later'])->assertCreated()->assertJsonPath('data.id', 5001);
});

it('uses the destination category default when transforming and clears incompatible statuses', function () {
    $source = $this->postJson($this->url, ['label' => 'Source'])->json('data.id');
    $destination = statusCategory();
    $targetUrl = "/api/1.0/campaigns/1/entity_types/{$destination->id}/statuses";
    $target = $this->postJson($targetUrl, ['label' => 'Destination', 'is_default' => true])->json('data.id');
    $entity = statusEntry($this->category, ['status_id' => $source]);
    app(TransformService::class)->campaign($this->campaign)->entity($entity)->entityType($destination)->transform();
    expect($entity->refresh()->type_id)->toBe($destination->id)->and($entity->status_id)->toBe($target);
    app(TransformService::class)->campaign($this->campaign)->entity($entity)->entityType($this->category)->transform();
    expect($entity->refresh()->status_id)->toBeNull();
});

it('preserves source statuses in same category copy forms and clears them across campaigns', function () {
    $id = $this->postJson($this->url, ['label' => 'Copied'])->json('data.id');
    $source = statusEntry($this->category, ['status_id' => $id]);
    $html = view('cruds.fields.status', ['campaign' => $this->campaign, 'entityType' => $this->category, 'source' => $source])->render();
    $document = new DOMDocument;
    $document->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING);
    expect((new DOMXPath($document))->query('//select[@name="status_id"]/option[@selected]')->item(0)->getAttribute('value'))->toBe((string) $id);
    $service = app(MoveService::class)->campaign($this->campaign)->entity($source)->to($this->campaign);
    expect((new ReflectionMethod($service, 'transferableStatusId'))->invoke($service))->toBe($id);
    $service->to(Campaign::factory()->create(['boost_count' => 4]));
    expect((new ReflectionMethod($service, 'transferableStatusId'))->invoke($service))->toBeNull();
});
