@if (!empty($entity->child->price) || !empty($entity->child->size) || !empty($entity->child->weight) || $entity->child->itemCreators->isNotEmpty())
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
@if ($entity->child->itemCreators->isNotEmpty())
- **{!! __('items.fields.creators') !!}** @foreach ($entity->child->itemCreators as $itemCreator){!! $itemCreator->creator->name !!}@if (!$loop->last), @endif @endforeach

@endif
