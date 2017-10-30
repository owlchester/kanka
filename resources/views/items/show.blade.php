@extends('layouts.app', ['title' => trans('items.show.title', ['item' => $item->name]), 'description' => trans('items.show.description')])

@section('content')
    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="/storage/{{ $item->image }}" alt="{{ $item->name }} picture">

                    <h3 class="profile-username text-center">{{ $item->name }}</h3>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>{{ trans('items.fields.type') }}</b> <a class="pull-right">{{ $item->type }}</a>
                        </li>
                        @if (!empty($item->location))
                            <li class="list-group-item">
                                <b>{{ trans('items.fields.location') }}</b> <a class="pull-right" href="{{ route('locations.show', $item->location_id) }}">{{ $item->location->name }}</a>
                            </li>
                        @endif
                        @if (!empty($item->character))
                            <li class="list-group-item">
                                <b>{{ trans('items.fields.character') }}</b> <a class="pull-right" href="{{ route('characters.show', $item->character_id) }}">{{ $item->character->name }}</a>
                            </li>
                        @endif
                    </ul>

                    <a href="{{ route('items.edit', $item->id) }}" class="btn btn-primary btn-block">
                        <i class="fa fa-pencil" aria-hidden="true"></i> {{ trans('crud.update') }}
                    </a>

                    {!! Form::open(['method' => 'DELETE','route' => ['items.destroy', $item->id],'style'=>'display:inline']) !!}
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
                    <li class="active"><a href="#information" data-toggle="tab" aria-expanded="false">Information</a></li>
                    <!--<li><a href="#character" data-toggle="tab" aria-expanded="false">Characters</a></li>-->
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="information">
                        @if (!empty($item->description))
                        <div class="post">
                            <h3>Description</h3>
                            <p>{!! $item->description !!}</p>
                        </div>
                        @endif

                        @if (!empty($item->history))
                        <div class="post">
                            <h3>History</h3>
                            <p>{!! $item->history !!}</p>
                        </div>
                        @endif
                    </div>
                    <div class="tab-pane" id="character">
                    </div>
                </div>
            </div>
            </div>

            <!-- actions -->
        </div>
    </div>
@endsection
