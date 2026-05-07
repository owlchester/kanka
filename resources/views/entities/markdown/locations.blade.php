@if (!empty($entity->child->title) || $entity->status)
## {!! __('crud.tabs.profile') !!}
@endif

@if (!empty($entity->child->title))
- **{!! __('locations.fields.title') !!}** {!! $entity->child->title !!}
@endif
@if ($entity->status)
* {{ $entity->status->setRelation('entityType', $entity->entityType)->name() }}
@endif