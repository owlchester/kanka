@if ($entity->child->status_id !== \App\Enums\QuestStatus::notStarted)
## {!! __('crud.tabs.profile') !!}

* {{ __('quests.fields.status') }}: {{ __('quests.status.' . ['not_started', 'ongoing', 'completed', 'abandoned'][$entity->child->status_id->value]) }}
@endif