@extends('layouts.ajax', [
    'title' => __('conversations.participants.title', ['name' => $model->name]),
    'breadcrumbs' => [
        ['url' => route('conversations.index'), 'label' => __('entities.conversations')],
        ['url' => route('conversations.show', $model->id), 'label' => $model->name],
        __('crud.update'),
    ]
])
<?php $campaign = CampaignLocalization::getCampaign(); ?>

@section('content')
    <div class="modal-header">
        <x-dialog.close />
        <h4>{{ __('conversations.participants.modal', ['name' => $model->name]) }}</h4>
    </div>
    <div class="modal-body">
        <ul class="list-group list-group-unbordered mb-5">
            @foreach ($model->participants as $participant)
                @if ($participant->isMember() || (auth()->check() && auth()->user()->can('view', $participant->entity())))
                <li class="list-group-item">
                    @can('update', $model)
                        {!! Form::open(['method' => 'DELETE', 'route' => ['conversations.conversation_participants.destroy', $model, $participant], 'style'=>'display:inline']) !!}
                    @endcan

                    @if ($participant->isMember())
                        {{ $participant->entity()->name }}
                    @else
                        <a href="{{ route('characters.show', $participant->entity()) }}">{{ $participant->entity()->name }}</a>
                    @endif

                    @can('update', $model)
                        <button class="btn btn-xs btn-danger pull-right">
                            <x-icon class="trash"></x-icon> {{ __('crud.remove') }}
                        </button>
                        {!! Form::close() !!}
                    @endcan
                </li>
                @endif
            @endforeach
        </ul>

        @can('update', $model)
            @include('partials.errors')
            <?php $memberList = $campaign->membersList($model->participantsList(false)); ?>
            @if($model->forCharacters() || count($memberList) > 0)
            {!! Form::open(['route' => ['conversations.conversation_participants.store', $model], 'method'=>'POST', 'data-shortcut' => "1"]) !!}
            <div class="flex gap-2 items-center">
                <div class="grow">
                    <div class="form-group required">
                        @if ($model->forCharacters())
                            @include('cruds.fields.character')
                        @else
                            {!! Form::select(
                                'user_id',
                                $memberList,
                                null,
                                ['class' => 'form-control']
                            ) !!}
                        @endif
                    </div>
                </div>
                <div class="flex-none">
                    @if ($model->target ==  \App\Models\Conversation::TARGET_CHARACTERS)
                        <label></label>
                    @endif
                    <button class="btn btn-primary btn-info btn-flat btn-block">
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
