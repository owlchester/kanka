@if ($entity->child->isDefunct())
## {!! __('crud.tabs.profile') !!}

* {{ __('organisations.hints.is_defunct') }}
@endif