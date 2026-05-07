@if ($entity->status)
## {!! __('crud.tabs.profile') !!}
@endif

* {{ $entity->status->setRelation('entityType', $entity->entityType)->name() }}
