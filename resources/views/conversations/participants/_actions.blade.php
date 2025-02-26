<?php /** @var \App\Models\Conversation $model */?>
@can('update', $model->entity)
    <?php $memberList = $campaign->membersList($model->participantsList(false, true)); ?>
    @if($model->forCharacters() || count($memberList) > 0)
        <x-form :action="['conversations.conversation_participants.store', $campaign, $model]">
        <div class="flex gap-2 items-end w-full">
            <div class="grow">
                @if ($model->forCharacters())
                    @include('cruds.fields.character', ['allowNew' => false])
                @else
                    <x-forms.select name="user_id" :options="$memberList" :selected="$source->user_id ?? $model->user_id ?? null" />
                @endif
            </div>
            <div class="">
                <button type="submit" class="btn2 btn-primary btn-sm">
                    <x-icon class="plus" /> {{ __('crud.add') }}
                </button>
            </div>
        </div>
        <input type="hidden" name="conversation_id" value="{{ $model->id }}" />
        </x-form>
    @endif
@endcan
