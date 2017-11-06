@extends('layouts.app', [
    'title' => trans('locations.show.title', ['location' => $location->name]),
    'description' => trans('locations.show.description'),
    'breadcrumbs' => [
        ['url' => route('locations.index'), 'label' => trans('locations.index.title')],
        $location->name,
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box">
                <div class="box-body box-profile">
                    @if ($location->image)
                    <a href="/storage/{{ $location->image }}">
                        <img class="profile-user-img img-responsive img-circle" src="/storage/{{ $location->image }}" alt="{{ $location->name }} picture">
                    </a>
                    @endif

                    <h3 class="profile-username text-center">{{ $location->name }}</h3>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>{{ trans('locations.fields.type') }}</b> <a class="pull-right">{{ $location->type }}</a>
                        </li>
                        @if (!empty($location->parent_location_id))
                            <li class="list-group-item">
                                <b>{{ trans('locations.fields.location') }}</b> <a class="pull-right" href="{{ route('locations.show', $location->parent_location_id) }}">{{ $location->parentLocation->name }}</a>
                            </li>
                        @endif
                    </ul>

                    <a href="{{ route('locations.edit', $location->id) }}" class="btn btn-primary btn-block">
                        <i class="fa fa-pencil" aria-hidden="true"></i> {{ trans('crud.update') }}
                    </a>

                        <button class="btn btn-block btn-danger delete-confirm" data-name="{{ $location->name }}" data-toggle="modal" data-target="#delete-confirm">
                            <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                        </button>
                        {!! Form::open(['method' => 'DELETE','route' => ['locations.destroy', $location->id], 'style'=>'display:inline', 'id' => 'delete-confirm-form']) !!}
                        {!! Form::close() !!}

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            <!-- About Me Box -->
            <!--<div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"></h3>
                </div>
                <div class="box-body">

                    <ul class="list-group list-group-unbordered">
                        @foreach ($location->locationAttributes as $attribute)
                        <li class="list-group-item">
                            <b>{{ $attribute->name }}</b> <span class="pull-right">{{ $attribute->value }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>-->
            <!-- /.box -->
        </div>

        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="{{ (request()->get('tab') == null ? ' active' : '') }}"><a href="#information" data-toggle="tab" aria-expanded="false">{{ trans('locations.show.tabs.information') }}</a></li>
                    <li class="{{ (request()->get('tab') == 'character' ? ' active' : '') }}"><a href="#character" data-toggle="tab" aria-expanded="false">{{ trans('locations.show.tabs.characters') }}</a></li>
                    <li class="{{ (request()->get('tab') == 'location' ? ' active' : '') }}"><a href="#location" data-toggle="tab" aria-expanded="false">{{ trans('locations.show.tabs.locations') }}</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="information">
                        <div class="post">
                            <h3>{{ trans('locations.fields.description') }}</h3>
                            <p>{!! $location->description !!}</p>
                        </div>

                        <div class="post">
                            <h3>{{ trans('locations.fields.history') }}</h3>
                            <p>{!! $location->history !!}</p>
                        </div>
                    </div>
                    <div class="tab-pane {{ (request()->get('tab') == 'character' ? ' active' : '') }}" id="character">
                        @include('locations._characters')
                    </div>
                    <div class="tab-pane {{ (request()->get('tab') == 'location' ? ' active' : '') }}" id="location">
                        @include('locations._locations')
                    </div>
                </div>
            </div>
            </div>

            <!-- actions -->
        </div>
    </div>
@endsection
