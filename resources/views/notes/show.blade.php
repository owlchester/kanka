@extends('layouts.app', [
    'title' => trans('notes.show.title', ['note' => $note->name]),
    'description' => trans('notes.show.description'),
    'breadcrumbs' => [
        ['url' => route('notes.index'), 'label' => trans('notes.index.title')],
        $note->name,
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box">
                <div class="box-body box-profile">
                    @if ($note->image)
                    <a href="/storage/{{ $note->image }}">
                        <img class="profile-user-img img-responsive img-circle" src="/storage/{{ $note->image }}" alt="{{ $note->name }} picture">
                    </a>
                    @endif

                    <h3 class="profile-username text-center">{{ $note->name }}</h3>

                    <ul class="list-group list-group-unbordered">
                        @if (!empty($note->type))
                            <li class="list-group-item">
                                <b>{{ trans('notes.fields.type') }}</b> <a class="pull-right" href="#">{{ $note->type }}</a>
                                <br class="clear" />
                            </li>
                        @endif
                    </ul>

                    <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-primary btn-block">
                        <i class="fa fa-pencil" aria-hidden="true"></i> {{ trans('crud.update') }}
                    </a>

                    <button class="btn btn-block btn-danger delete-confirm" data-name="{{ $note->name }}" data-toggle="modal" data-target="#delete-confirm">
                        <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                    </button>
                    {!! Form::open(['method' => 'DELETE','route' => ['notes.destroy', $note->id], 'style'=>'display:inline', 'id' => 'delete-confirm-form']) !!}
                    {!! Form::close() !!}

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

        </div>

        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="{{ (request()->get('tab') == null ? ' active' : '') }}"><a href="#history" data-toggle="tab" aria-expanded="false">{{ trans('notes.show.tabs.description') }}</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="history">
                        <div class="post">
                            <p>{!! $note->description !!}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- actions -->
        </div>
    </div>
@endsection
