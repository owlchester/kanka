<?php

use App\Models\Campaign;
use App\Models\EntityType;

it('uses the note-specific parent field in the filter and bulk edit forms', function () {
    $this->asUser()->withCampaign();
    $campaign = Campaign::findOrFail(1);
    $type = EntityType::findOrFail(config('entities.ids.note'));

    $this->get(route('filters.form', [$campaign, $type]))->assertOk()
        ->assertViewHas('filters', fn (array $filters) => collect($filters)->contains(
            fn ($filter) => is_array($filter)
                && ($filter['field'] ?? null) === 'parent_id'
                && $filter['route'] === route('search-list', [$campaign, $type->id, 'entity' => true]),
        ));

    $this->get(route('bulk.batch', [$campaign, $type, 'entities' => [1]]))->assertOk()
        ->assertViewHas('bulk', fn ($bulk) => $bulk->fields() === [
            'name', 'type', 'parent_id', 'tags', 'private_choice', 'entity_image', 'entity_header',
        ]);
});
