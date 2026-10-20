@if ($entity->status)
## {!! __('crud.tabs.profile') !!}

* {{ $entity->status->setRelation('entityType', $entity->entityType)->name() }}
@endif
@if (!empty($entityData['questElements']))
## {!! __('quests.show.tabs.elements') !!}

@foreach ($entityData['questElements'] as $element)
### @if ($element['entity']){!! $element['entity'] !!}@else{!! html_entity_decode($element['name'], ENT_QUOTES, 'UTF-8') !!}@endif
@if (!empty($element['role']))
**{!! __('quests.fields.role') !!}:** {!! html_entity_decode($element['role'], ENT_QUOTES, 'UTF-8') !!}
@endif

{!! $converter->convert((string) $element['entry']) !!}

@endforeach
@endif
