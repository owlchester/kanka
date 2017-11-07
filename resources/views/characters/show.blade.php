@extends('layouts.app', [
    'title' => trans('characters.show.title', ['character' => $character->name]),
    'description' => trans('characters.show.description'),
    'breadcrumbs' => [
        ['url' => route('characters.index'), 'label' => trans('characters.index.title')],
        $character->name,
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box">
                <div class="box-body box-profile">
                    @if ($character->image)
                    <a href="/storage/{{ $character->image }}">
                        <img class="profile-user-img img-responsive img-circle" src="/storage/{{ $character->image }}" alt="{{ $character->name }} picture">
                    </a>
                    @endif

                    <h3 class="profile-username text-center">{{ $character->name }}</h3>

                    @if ($character->title)
                        <p class="text-muted text-center">{{ $character->title }}</p>
                    @endif

                    <ul class="list-group list-group-unbordered">
                        @if (!empty($character->family_id))
                            <li class="list-group-item">
                                <b>{{ trans('characters.fields.family') }}</b> <a class="pull-right" href="{{ route('families.show', $character->family_id) }}">{{ $character->family->name }}</a>
                            </li>
                        @endif
                        @if (!empty($character->location_id))
                            <li class="list-group-item">
                                <b>{{ trans('characters.fields.location') }}</b> <a class="pull-right" href="{{ route('locations.show', $character->location_id) }}">{{ $character->location->name }}</a>
                            </li>
                        @endif
                        @if (!empty($character->race))
                        <li class="list-group-item">
                            <b>{{ trans('characters.fields.race') }}</b> <span class="pull-right">{{ $character->race }}</span>
                        </li>
                        @endif
                    </ul>

                    <a href="{{ route('characters.edit', ['id' => $character->id]) }}" class="btn btn-primary btn-block">
                        <i class="fa fa-pencil" aria-hidden="true"></i> {{ trans('crud.update') }}
                    </a>

                    <button class="btn btn-block btn-danger delete-confirm" data-name="{{ $character->name }}" data-toggle="modal" data-target="#delete-confirm">
                        <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                    </button>
                    {!! Form::open(['method' => 'DELETE','route' => ['characters.destroy', $character->id], 'style'=>'display:inline', 'id' => 'delete-confirm-form']) !!}
                    {!! Form::close() !!}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            <!-- About Me Box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('characters.fields.physical') }}</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <ul class="list-group list-group-unbordered">
                        @if ($character->age)
                        <li class="list-group-item">
                            <b>{{ trans('characters.fields.age') }}</b> <span class="pull-right">{{ $character->age }}</span>
                        </li>
                        @endif
                        @if ($character->sex)
                        <li class="list-group-item">
                            <b>{{ trans('characters.fields.sex') }}</b> <span class="pull-right">{{ $character->sex }}</span>
                        </li>
                        @endif
                        @if ($character->height)
                        <li class="list-group-item">
                            <b>{{ trans('characters.fields.height') }}</b> <span class="pull-right">{{ $character->height }}</span>
                        </li>
                        @endif
                        @if ($character->weight)
                        <li class="list-group-item">
                            <b>{{ trans('characters.fields.weight') }}</b> <span class="pull-right">{{ $character->weight }}</span>
                        </li>
                        @endif
                        @if ($character->eye_colour)
                        <li class="list-group-item">
                            <b>{{ trans('characters.fields.eye') }}</b> <span class="pull-right">{{ $character->eye_colour }}</span>
                        </li>
                        @endif
                        @if ($character->hair)
                        <li class="list-group-item">
                            <b>{{ trans('characters.fields.hair') }}</b> <span class="pull-right">{{ $character->hair }}</span>
                        </li>
                        @endif
                        @if ($character->skin)
                        <li class="list-group-item">
                            <b>{{ trans('characters.fields.skin') }}</b> <span class="pull-right">{{ $character->skin }}</span>
                        </li>
                        @endif
                        @if ($character->languages)
                        <li class="list-group-item">
                            <b>{{ trans('characters.fields.languages') }}</b> <span class="pull-right">{{ $character->languages }}</span>
                        </li>
                        @endif
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="{{ (request()->get('tab') == null ? ' active' : '') }}"><a href="#history" data-toggle="tab" aria-expanded="false">
                            {{ trans('characters.show.tabs.history') }}
                        </a></li>
                    <li class="{{ (request()->get('tab') == 'personality' ? ' active' : '') }}"><a href="#personality" data-toggle="tab" aria-expanded="false">
                            {{ trans('characters.show.tabs.personality') }}
                        </a></li>
                    <li class="{{ (request()->get('tab') == 'free' ? ' active' : '') }}"><a href="#free" data-toggle="tab" aria-expanded="false">
                            {{ trans('characters.show.tabs.free') }}
                        </a></li>
                    <li class="{{ (request()->get('tab') == 'relation' ? ' active' : '') }}"><a href="#relation" data-toggle="tab" aria-expanded="false">
                            {{ trans('characters.show.tabs.relations') }}
                        </a></li>
                    <li class="{{ (request()->get('tab') == 'organisation' ? ' active' : '') }}"><a href="#organisation" data-toggle="tab" aria-expanded="false">
                            {{ trans('characters.show.tabs.organisations') }}
                        </a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="history">
                        <div class="post">
                            <p>{!! $character->history !!}</p>
                        </div>
                    </div>
                    <div class="tab-pane {{ (request()->get('tab') == 'personality' ? ' active' : '') }}" id="personality">
                        <p><b>{{ trans('characters.fields.traits') }}</b><br />{!! nl2br(e($character->traits)) !!}</p>
                        <p><b>{{ trans('characters.fields.goals') }}</b><br />{!! nl2br(e($character->goals)) !!}</p>
                        <p><b>{{ trans('characters.fields.fears') }}</b><br />{!! nl2br(e($character->fears)) !!}</p>
                        <p><b>{{ trans('characters.fields.mannerisms') }}</b><br />{!! nl2br(e($character->mannerisms)) !!}</p>
                    </div>
                    <div class="tab-pane {{ (request()->get('tab') == 'free' ? ' active' : '') }}" id="free">
                        <div class="post">
                            <p>{!! nl2br(e($character->free)) !!}</p>
                        </div>
                    </div>
                    <div class="tab-pane {{ (request()->get('tab') == 'relation' ? ' active' : '') }}" id="relation">
                        @include('characters._relations')
                    </div>
                    <div class="tab-pane {{ (request()->get('tab') == 'organisation' ? ' active' : '') }}" id="organisation">
                        @include('characters._organisations')
                    </div>
                </div>
            </div>

            <!-- actions -->
        </div>
    </div>
@endsection
