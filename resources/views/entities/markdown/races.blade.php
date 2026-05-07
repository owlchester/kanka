@if ($entity->status)
## {!! __('crud.tabs.profile') !!}

* {{ $entity->status->setRelation('entityType', $entity->entityType)->name() }}
@endif