<?php

use App\Jobs\Search\MakeSearchable;
use App\Models\Character;
use App\Models\Creature;
use App\Models\EntityType;
use App\Services\Entity\TransformService;
use Illuminate\Support\Facades\Queue;

it('restores a queued search update after the entity changes type', function () {
    $this->asUser()->withCampaign();
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $entity->load('child.characterRaces');
    $destination = EntityType::findOrFail(config('entities.ids.creature'));

    config(['scout.queue' => true]);
    Queue::fake([MakeSearchable::class]);
    $entity->searchable();
    Queue::assertPushed(MakeSearchable::class, 1);
    $payload = serialize(Queue::pushed(MakeSearchable::class)->sole());

    app(TransformService::class)->campaign($entity->campaign)->entity($entity)->entityType($destination)->transform();

    $restored = unserialize($payload)->models->sole();
    expect($restored->id)->toBe($entity->id)
        ->and($restored->child)->toBeInstanceOf(Creature::class);
});
