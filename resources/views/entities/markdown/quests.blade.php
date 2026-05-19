@if ($entity->child->status_id !== \App\Enums\QuestStatus::notStarted)
## {!! __('crud.tabs.profile') !!}

* {{ $entity->status->setRelation('entityType', $entity->entityType)->name() }}
@endif