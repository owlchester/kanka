@php
    $creators = $entity->child->itemCreators->filter(fn ($itemCreator) => $itemCreator->creator !== null);
@endphp

@if (!empty($entity->child->price) || !empty($entity->child->size) || !empty($entity->child->weight) || $creators->isNotEmpty())
## {!! __('crud.tabs.profile') !!}
@endif

@if (!empty($entity->child->price))
- **{!! __('items.fields.price') !!}** {!! $entity->child->price !!}
@endif
@if (!empty($entity->child->size))
- **{!! __('items.fields.size') !!}** {!! $entity->child->size !!}
@endif
@if (!empty($entity->child->weight))
- **{!! __('items.fields.weight') !!}** {!! $entity->child->weight !!}
@endif
@if ($creators->isNotEmpty())
- **{!! __('items.fields.creators') !!}** @foreach ($creators as $itemCreator){!! $itemCreator->creator->name !!}@if (!$loop->last), @endif @endforeach

@endif
