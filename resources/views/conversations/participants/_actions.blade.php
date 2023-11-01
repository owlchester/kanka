@can('update', $model)
    <?php $memberList = $campaign->membersList($model->participantsList(false, true)); ?>
    @if($model->forCharacters() || count($memberList) > 0)
        {!! Form::open(['route' => ['conversations.conversation_participants.store', $campaign, $model], 'method' => 'POST', 'data-shortcut' => 1, 'class' => ' w-full']) !!}
        <div class="flex gap-2 items-end w-full">
            <div class="grow">
                @if ($model->forCharacters())
                    @include('cruds.fields.character', ['allowNew' => false])
                @else
                    {!! Form::select(
                        'user_id',
                        $memberList,
                        null,
                        ['class' => 'w-full']
                    ) !!}
                @endif
            </div>
            <div class="">
                <button class="btn2 btn-primary btn-sm">
                    <x-icon class="plus"></x-icon> {{ __('crud.add') }}
                </button>
            </div>
        </div>
        {!! Form::hidden('conversation_id', $model->id) !!}
        {!! Form::close() !!}
    @endif
@endcan
