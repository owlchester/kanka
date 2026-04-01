@if (!empty($entity->child->title) || $entity->child->isDestroyed())
## {!! __('crud.tabs.profile') !!}
@endif

@if (!empty($entity->child->title))
* **{!! __('locations.fields.title') !!}** {!! $entity->child->title !!}
@endif
@if ($entity->child->isDestroyed())
* {{ __('locations.hints.is_destroyed') }}
@endif