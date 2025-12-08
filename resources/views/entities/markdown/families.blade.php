@if ($entity->child->isExtinct())
## {!! __('crud.tabs.profile') !!}

* {{ __('families.hints.is_extinct') }}
@endif