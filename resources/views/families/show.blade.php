@extends('layouts.app', ['title' => trans('families.show.title', ['family' => $family->name]), 'description' => trans('families.show.description')])

@section('content')
    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    @if ($family->image)
                    <a href="/storage/{{ $family->image }}">
                        <img class="profile-user-img img-responsive img-circle" src="/storage/{{ $family->image }}" alt="{{ $family->name }} picture">
                    </a>
                    @endif

                    <h3 class="profile-username text-center">{{ $family->name }}</h3>

                    <ul class="list-group list-group-unbordered">
                        @if (!empty($family->location_id))
                        <li class="list-group-item">
                            <b>Location</b> <a class="pull-right" href="{{ route('locations.show', $family->location_id) }}">{{ $family->location->name }}</a>
                        </li>
                        @endif
                    </ul>

                    <a href="{{ route('families.edit', $family->id) }}" class="btn btn-primary btn-block">
                        <i class="fa fa-pencil" aria-hidden="true"></i> {{ trans('crud.update') }}
                    </a>

                    {!! Form::open(['method' => 'DELETE','route' => ['families.destroy', $family->id],'style'=>'display:inline']) !!}
                    <button class="btn btn-block btn-danger">
                        <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                    </button>
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
                    <li class="{{ (request()->get('tab') == 'relation' ? ' active' : '') }}"><a href="#relation" data-toggle="tab" aria-expanded="false">Relations</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="history">
                        <div class="post">
                            <p>{!! $family->history !!}</p>
                        </div>
                    </div>
                    <div class="tab-pane {{ (request()->get('tab') == 'member' ? ' active' : '') }}" id="member">
                        @include('families._members')
                    </div>
                    <div class="tab-pane {{ (request()->get('tab') == 'relation' ? ' active' : '') }}" id="relation">
                        @include('families._relations')
                    </div>
                </div>
            </div>

            <!-- actions -->
        </div>
    </div>
@endsection
