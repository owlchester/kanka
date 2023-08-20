@extends('layouts.ajax', [
    'title' => __('conversations.participants.title', ['name' => $model->name]),
    'breadcrumbs' => [
        ['url' => route('conversations.index', $campaign), 'label' => __('entities.conversations')],
        ['url' => route('conversations.show', [$campaign, $model->id]), 'label' => $model->name],
        __('crud.update'),
    ]
])

@section('content')
    <div class="modal-header">
        <x-dialog.close />
        <h4>{{ __('conversations.participants.modal', ['name' => $model->name]) }}</h4>
    </div>
    <div class="modal-body">
        <div class="mb-5">
            @foreach ($model->participants as $participant)
                @if ($participant->isMember() || (auth()->check() && auth()->user()->can('view', $participant->entity())))
                    @can('update', $model)
                        {!! Form::open(['method' => 'DELETE', 'route' => ['conversations.conversation_participants.destroy', $campaign, $model, $participant], 'class'=>'flex gap-2 mb-2']) !!}
                    @endcan

                    <div class="grow">
                    @if ($participant->isMember())
                        {{ $participant->entity()->name }}
                    @else
                        <a href="{{ route('characters.show', [$campaign, $participant->entity()]) }}">{{ $participant->entity()->name }}</a>
                    @endif
                    </div>

                    @can('update', $model)
                        <button class="btn2 btn-error btn-outline btn-sm">
                            <x-icon class="trash"></x-icon>
                            <span class="sr-only">{{ __('crud.remove') }}</span>
                        </button>
                        {!! Form::close() !!}
                    @endcan
                @endif
            @endforeach
        </div>

        @can('update', $model)
            @include('partials.errors')
            <?php $memberList = $campaign->membersList($model->participantsList(false)); ?>
            @if($model->forCharacters() || count($memberList) > 0)
            {!! Form::open(['route' => ['conversations.conversation_participants.store', $campaign, $model], 'method'=>'POST', 'data-shortcut' => "1"]) !!}
            <div class="flex gap-2 items-center">
                <div class="grow">
                    @if ($model->forCharacters())
                        @include('cruds.fields.character', ['allowNew' => false])
                    @else
                        {!! Form::select(
                            'user_id',
                            $memberList,
                            null,
                            ['class' => 'form-control']
                        ) !!}
                    @endif
                </div>
                <div class="">
                    @if ($model->target ==  \App\Models\Conversation::TARGET_CHARACTERS)
                        <label></label>
                    @endif
                    <button class="btn2 btn-primary btn-block">
                        <x-icon class="plus"></x-icon> {{ __('crud.add') }}
                    </button>
                </div>
            </div>
            {!! Form::hidden('conversation_id', $model->id) !!}
            {!! Form::close() !!}
            @endif
        @endcan
    </div>
@endsection
