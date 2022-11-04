<?php
    if ($model instanceof \App\Models\EntityNote) {
        $url = route('posts.confirm-editing', ['entity_note' => $model, 'entity' => $entity]);
        $key = 'entities/story.warning.editing.user';
    } elseif ($model instanceof \App\Models\Campaign) {
        $url = route('campaigns.confirm-editing', $model);
        $key = 'entities/story.warning.editing.user';
    } elseif ($model instanceof \App\Models\TimelineElement) {
        $url = route('timeline-elements.confirm-editing', $model);
        $key = 'entities/story.warning.editing.user';
    } elseif ($model instanceof \App\Models\QuestElement) {
        $url = route('quest-elements.confirm-editing', $model);
        $key = 'entities/story.warning.editing.user';
    } else {
        $url = route('entities.confirm-editing', $model->entity);
        $key = 'entities/story.warning.editing.user';
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
                    {{ __('entities/notes.warning.editing.description') }}
                </p>
                <ul>
                    @foreach ($editingUsers as $user)
                        <li class="user-id-{{ $user->id }}">{{ __($key, ['user' => $user->name, 'since' => \Carbon\Carbon::createFromTimeString($user->pivot->created_at)->diffForHumans()]); }}</li>
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
