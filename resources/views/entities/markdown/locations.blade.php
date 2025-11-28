@if ($entity->child->isDestroyed())
## {!! __('crud.tabs.profile') !!}

* {{ __('locations.hints.is_destroyed') }}
@endif