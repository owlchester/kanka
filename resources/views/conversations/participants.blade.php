@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans('conversations.participants.title', ['name' => $model->name]),
    'description' => trans('conversations.participants.description'),
    'breadcrumbs' => [
        ['url' => route('conversations.index'), 'label' => trans('conversations.index.title')],
        ['url' => route('conversations.show', $model->id), 'label' => $model->name],
        trans('crud.update'),
    ]
])
<?php $campaign = CampaignLocalization::getCampaign(); ?>

@section('content')
    <div class="panel panel-default">
        @if ($ajax)
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4>{{ trans('conversations.participants.modal', ['name' => $model->name]) }}</h4>
            </div>
        @endif
        <div class="panel-body">
            <ul class="list-group list-group-unbordered margin-bottom">
                @foreach ($model->participants as $participant)
                    <li class="list-group-item">
                        @can('update', $model)
                            {!! Form::open(['method' => 'DELETE', 'route' => ['conversations.conversation_participants.destroy', 'conversation' => $model, 'participant' => $participant], 'style'=>'display:inline']) !!}
                        @endcan
                        <b>
                        @if ($participant->target() == \App\Models\Conversation::TARGET_USERS)
                            {{ $participant->entity()->name }}
                        @else
                            <a href="{{ route('characters.show', $participant->entity()) }}">{{ $participant->entity()->name }}</a>
                        @endif
                        </b>


                        <button class="btn btn-xs btn-danger pull-right">
                            <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                        </button>
                        @can('update', $model)
                            {!! Form::close() !!}
                        @endcan
                    </li>
                @endforeach
            </ul>

            @can('update', $model)
                @include('partials.errors')
                {!! Form::open(['route' => ['conversations.conversation_participants.store', $model], 'method'=>'POST', 'data-shortcut' => "1"]) !!}
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group required">
                            @if ($model->target ==  \App\Models\Conversation::TARGET_CHARACTERS)
                            {!! Form::select2(
                                'character_id',
                                null,
                                App\Models\Character::class,
                                false
                            ) !!}
                            @else
                                {!! Form::select(
                                    'user_id',
                                    $campaign->membersList($model->participantsList(false)),
                                    null,
                                    ['class' => 'form-control']
                                ) !!}
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <button class="btn btn-primary btn-info btn-flat btn-block">
                            <i class="fa fa-plus"></i> {{ trans('crud.add') }}
                        </button>
                    </div>
                </div>
                {!! Form::hidden('conversation_id', $model->id) !!}
                {!! Form::close() !!}
            @endcan
        </div>
    </div>
@endsection