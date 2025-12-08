@if ($entity->child->isCompleted())
## {!! __('crud.tabs.profile') !!}

* {{ __('quests.fields.is_completed') }}
@endif