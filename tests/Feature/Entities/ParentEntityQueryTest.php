<?php

use App\Models\CampaignDashboardWidget;
use App\Models\Character;

it('filters child models using shared entity fields', function () {
    $this->asUser()->withCampaign();

    $matching = Character::factory()->create(['campaign_id' => 1]);
    $other = Character::factory()->create(['campaign_id' => 1]);

    $matching->entity->update([
        'name' => 'Shared filter value',
        'parent_id' => $other->entity->id,
        'status_id' => 3,
    ]);
    $other->entity->update(['name' => 'Different value', 'status_id' => 4]);

    expect(Character::query()->filter(['name' => 'Shared filter'])->pluck('characters.id')->all())
        ->toContain($matching->id)
        ->not->toContain($other->id);
    expect(Character::query()->filter(['parent_id' => (string) $other->entity->id])->pluck('characters.id')->all())
        ->toContain($matching->id)
        ->not->toContain($other->id);
    expect(Character::query()->filter(['status_id' => '3'])->pluck('characters.id')->all())
        ->toContain($matching->id)
        ->not->toContain($other->id);
});

it('applies dashboard filters through a child subquery', function () {
    $this->asUser()->withCampaign();

    $matching = Character::factory()->create(['campaign_id' => 1]);
    $other = Character::factory()->create(['campaign_id' => 1]);
    $matching->entity->update(['name' => 'Dashboard match']);
    $other->entity->update(['name' => 'Dashboard other']);

    $widget = CampaignDashboardWidget::factory()->create([
        'campaign_id' => 1,
        'entity_type_id' => config('entities.ids.character'),
        'config' => ['filters' => 'name=Dashboard match'],
    ]);

    expect($widget->entities()->getCollection()->pluck('id')->all())
        ->toContain($matching->entity->id)
        ->not->toContain($other->entity->id);
});
