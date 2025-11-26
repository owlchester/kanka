@if ($entity->child->isExtinct())
## {!! __('crud.tabs.profile') !!}

* {{ __('races.hints.is_extinct') }}
@endif