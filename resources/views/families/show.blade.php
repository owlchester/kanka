@extends('layouts.app', [
    'title' => trans('families.show.title', ['family' => $family->name]),
    'description' => trans('families.show.description'),
    'breadcrumbs' => [
        ['url' => route('families.index'), 'label' => trans('families.index.title')],
        $family->name,
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box">
                <div class="box-body box-profile">
                    @if ($family->image)
                    <a href="/storage/{{ $family->image }}">
                        <img class="profile-user-img img-responsive img-circle" src="/storage/{{ $family->image }}" alt="{{ $family->name }} picture">
                    </a>
                    @endif

                    <h3 class="profile-username text-center">{{ $family->name }}
                        @if ($family->is_private)
                             <i class="fa fa-lock" title="{{ trans('crud.is_private') }}"></i>
                        @endif
                    </h3>

                    <ul class="list-group list-group-unbordered">
                        @if ($family->location)
                            <li class="list-group-item">
                                <b>{{ trans('families.fields.location') }}</b>
                                <span  class="pull-right">
                                <a href="{{ route('locations.show', $family->location_id) }}">{{ $family->location->name }}</a>
                                    @if ($family->location->parentLocation)
                                        , <a href="{{ route('locations.show', $family->location->parentLocation->id) }}">{{ $family->location->parentLocation->name }}</a>
                                    @endif
                                </span>
                                <br class="clear" />
                            </li>
                        @endif
                    </ul>

                    @if (Auth::user()->can('update', $family))
                    <a href="{{ route('families.edit', $family->id) }}" class="btn btn-primary btn-block">
                        <i class="fa fa-pencil" aria-hidden="true"></i> {{ trans('crud.update') }}
                    </a>
                    @endif

                    @if (Auth::user()->can('delete', $family))
                    <button class="btn btn-block btn-danger delete-confirm" data-name="{{ $family->name }}" data-toggle="modal" data-target="#delete-confirm">
                        <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                    </button>
                    {!! Form::open(['method' => 'DELETE','route' => ['families.destroy', $family->id], 'style'=>'display:inline', 'id' => 'delete-confirm-form']) !!}
                    {!! Form::close() !!}
                    @endif

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

        </div>

        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="{{ (request()->get('tab') == null ? ' active' : '') }}"><a href="#history" data-toggle="tab" aria-expanded="false">{{ trans('families.show.tabs.history') }}</a></li>
                    <li class="{{ (request()->get('tab') == 'member' ? ' active' : '') }}"><a href="#member" data-toggle="tab" aria-expanded="false">{{ trans('families.show.tabs.member') }}</a></li>
                    <li class="{{ (request()->get('tab') == 'relation' ? ' active' : '') }}"><a href="#relation" data-toggle="tab" aria-expanded="false">{{ trans('families.show.tabs.relation') }}</a></li>
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
