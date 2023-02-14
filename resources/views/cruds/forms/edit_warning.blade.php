<?php
    if ($model instanceof \App\Models\EntityNote) {
        $url = route('posts.confirm-editing', ['campaign' => $campaign, 'post' => $model, 'entity' => $entity]);
        $key = 'entities/notes.warning.editing.description';
    } elseif ($model instanceof \App\Models\Campaign) {
        $url = route('campaign.confirm-editing', $model);
        $key = 'campaigns.warning.editing.description';
    } elseif ($model instanceof \App\Models\TimelineElement) {
        $url = route('timeline-elements.confirm-editing', ['campaign' => $campaign, 'timeline_element' => $model]);
        $key = 'timelines/elements.warning.editing.description';
    } elseif ($model instanceof \App\Models\QuestElement) {
        $url = route('quest-elements.confirm-editing', ['campaign' => $campaign, 'quest_element' => $model]);
        $key = 'quests.elements.warning.editing.description';
    } else {
        $url = route('entities.confirm-editing', ['campaign' => $campaign, $model->entity]);
        $key = 'entities/story.warning.editing.description';
    }
?>
<div class="modal" id="entity-edit-warning" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">{{ __('entities/story.warning.editing.title') }}</h4>
            </div>
            <div class="modal-body modal-ajax-body">
                <p>
                    {{ __($key) }}
                </p>
                <ul>
                    @foreach ($editingUsers as $user)
                        <li class="user-id-{{ $user->id }}">{{ __('entities/story.warning.editing.user', ['user' => $user->name, 'since' => \Carbon\Carbon::createFromTimeString($user->pivot->created_at)->diffForHumans()]); }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-body modal-spinner-body text-center" style="display: none">
                <i class="fa-solid fa-spinner fa-spin fa-2x"></i>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" id="entity-edit-warning-back" data-url="{{ url()->previous() }}">
                    {{ __('entities/story.warning.editing.back') }}
                </button>

                <button type="button" class="btn btn-warning" id="entity-edit-warning-ignore" data-url="{{ $url }}">
                    {{ __('entities/story.warning.editing.ignore') }}
                </button>
            </div>
        </div>
    </div>
</div>
