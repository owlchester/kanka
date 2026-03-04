@if ($entity->child->is_completed > 0)
## {!! __('crud.tabs.profile') !!}

* {{ __('quests.fields.is_completed') }}: {{ __('quests.status.' . ['not_started', 'ongoing', 'completed', 'abandoned'][$entity->child->is_completed]) }}
@endif