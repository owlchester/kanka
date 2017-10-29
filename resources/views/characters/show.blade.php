@extends('layouts.app', ['title' => trans('characters.show.title', ['character' => $character->name]), 'description' => trans('characters.show.description')])

@section('content')
    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="/storage/{{ $character->image }}" alt="{{ $character->name }} picture">

                    <h3 class="profile-username text-center">{{ $character->name }}</h3>

                    <p class="text-muted text-center">{{ $character->title }}</p>

                    <ul class="list-group list-group-unbordered">
                        @if (!empty($character->location_id))
                        <li class="list-group-item">
                            <b>Location</b> <a class="pull-right" href="{{ route('locations.show', $character->location_id) }}">{{ $character->location->name }}</a>
                        </li>
                        @endif
                        <li class="list-group-item">
                            <b>Race</b> <span class="pull-right">{{ $character->race }}</span>
                        </li>
                    </ul>

                    <a href="{{ route('characters.edit', ['id' => $character->id]) }}" class="btn btn-primary btn-block">
                        {{ trans('crud.update') }}
                    </a>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Physical</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <ul class="list-group list-group-unbordered">
                        @if ($character->age)
                        <li class="list-group-item">
                            <b>Age</b> <span class="pull-right">{{ $character->age }}</span>
                        </li>
                        @endif
                        @if ($character->sex)
                        <li class="list-group-item">
                            <b>Sex</b> <span class="pull-right">{{ $character->sex }}</span>
                        </li>
                        @endif
                        @if ($character->height)
                        <li class="list-group-item">
                            <b>Height</b> <span class="pull-right">{{ $character->height }}</span>
                        </li>
                        @endif
                        @if ($character->weight)
                        <li class="list-group-item">
                            <b>Weight</b> <span class="pull-right">{{ $character->weight }}</span>
                        </li>
                        @endif
                        @if ($character->eye_colour)
                        <li class="list-group-item">
                            <b>Eye</b> <span class="pull-right">{{ $character->eye_colour }}</span>
                        </li>
                        @endif
                        @if ($character->hair)
                        <li class="list-group-item">
                            <b>Hair</b> <span class="pull-right">{{ $character->hair }}</span>
                        </li>
                        @endif
                        @if ($character->skin)
                        <li class="list-group-item">
                            <b>Skin</b> <span class="pull-right">{{ $character->skin }}</span>
                        </li>
                        @endif
                        @if ($character->languages)
                        <li class="list-group-item">
                            <b>Languages</b> <span class="pull-right">{{ $character->languages }}</span>
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
                    <li class="{{ (request()->get('tab') == null ? ' active' : '') }}"><a href="#history" data-toggle="tab" aria-expanded="false">History</a></li>
                    <li class="{{ (request()->get('tab') == 'personality' ? ' active' : '') }}"><a href="#personality" data-toggle="tab" aria-expanded="false">Personality</a></li>
                    <li class="{{ (request()->get('tab') == 'free' ? ' active' : '') }}"><a href="#free" data-toggle="tab" aria-expanded="false">Free text</a></li>
                    <li class="{{ (request()->get('tab') == 'relation' ? ' active' : '') }}"><a href="#relation" data-toggle="tab" aria-expanded="false">Relations</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="history">
                        <div class="post">
                            <p>{!! nl2br(e($character->history)) !!}</p>
                        </div>
                    </div>
                    <div class="tab-pane {{ (request()->get('tab') == 'personality' ? ' active' : '') }}" id="personality">
                        <p><b>Traits</b><br />{!! nl2br(e($character->traits)) !!}</p>
                        <p><b>Goals</b><br />{!! nl2br(e($character->goals)) !!}</p>
                        <p><b>Fears</b><br />{!! nl2br(e($character->fears)) !!}</p>
                        <p><b>Mannerisms</b><br />{!! nl2br(e($character->mannerisms)) !!}</p>
                    </div>
                    <div class="tab-pane {{ (request()->get('tab') == 'free' ? ' active' : '') }}" id="free">
                        <div class="post">
                            <p>{!! nl2br(e($character->free)) !!}</p>
                        </div>
                    </div>
                    <div class="tab-pane {{ (request()->get('tab') == 'relation' ? ' active' : '') }}" id="relation">
                        @include('characters._relations')
                    </div>
                </div>
            </div>

            <!-- actions -->
        </div>
    </div>
@endsection
