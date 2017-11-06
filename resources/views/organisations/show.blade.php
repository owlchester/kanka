@extends('layouts.app', [
    'title' => trans('organisations.show.title', ['organisation' => $organisation->name]),
    'description' => trans('organisations.show.description'),
    'breadcrumbs' => [
        ['url' => route('organisations.index'), 'label' => trans('organisations.index.title')],
        $organisation->name,
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box">
                <div class="box-body box-profile">
                    @if ($organisation->image)
                    <a href="/storage/{{ $organisation->image }}">
                        <img class="profile-user-img img-responsive img-circle" src="/storage/{{ $organisation->image }}" alt="{{ $organisation->name }} picture">
                    </a>
                    @endif

                    <h3 class="profile-username text-center">{{ $organisation->name }}</h3>

                    <ul class="list-group list-group-unbordered">
                        @if (!empty($organisation->location_id))
                        <li class="list-group-item">
                            <b>Location</b> <a class="pull-right" href="{{ route('locations.show', $organisation->location_id) }}">{{ $organisation->location->name }}</a>
                        </li>
                        @endif

                        @if (!empty($organisation->type))
                            <li class="list-group-item">
                                <b>Type</b> <a class="pull-right" href="#">{{ $organisation->type }}</a>
                            </li>
                        @endif
                    </ul>

                    <a href="{{ route('organisations.edit', $organisation->id) }}" class="btn btn-primary btn-block">
                        <i class="fa fa-pencil" aria-hidden="true"></i> {{ trans('crud.update') }}
                    </a>

                    <button class="btn btn-block btn-danger delete-confirm" data-name="{{ $organisation->name }}" data-toggle="modal" data-target="#delete-confirm">
                        <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                    </button>
                    {!! Form::open(['method' => 'DELETE','route' => ['organisations.destroy', $organisation->id], 'style'=>'display:inline', 'id' => 'delete-confirm-form']) !!}
                    {!! Form::close() !!}

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

        </div>

        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="{{ (request()->get('tab') == null ? ' active' : '') }}"><a href="#history" data-toggle="tab" aria-expanded="false">History</a></li>
                    <li class="{{ (request()->get('tab') == 'member' ? ' active' : '') }}"><a href="#member" data-toggle="tab" aria-expanded="false">Members</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="history">
                        <div class="post">
                            <p>{!! $organisation->history !!}</p>
                        </div>
                    </div>
                    <div class="tab-pane {{ (request()->get('tab') == 'member' ? ' active' : '') }}" id="member">
                        @include('organisations._members')
                    </div>
                </div>
            </div>

            <!-- actions -->
        </div>
    </div>
@endsection
