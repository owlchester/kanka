@extends('layouts.app', ['title' => trans('locations.show.title', ['location' => $location->name]), 'description' => trans('locations.show.description')])

@section('content')
    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="/storage/{{ $location->image }}" alt="{{ $location->name }} picture">

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
                        {{ trans('crud.update') }}
                    </a>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Attributes</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <ul class="list-group list-group-unbordered">
                        @foreach ($location->locationAttributes as $attribute)
                        <li class="list-group-item">
                            <b>{{ $attribute->name }}</b> <span class="pull-right">{{ $attribute->value }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#information" data-toggle="tab" aria-expanded="false">Information</a></li>
                    <li><a href="#character" data-toggle="tab" aria-expanded="false">Characters</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="information">
                        <div class="post">
                            <h3>Description</h3>
                            <p>{!! nl2br(e($location->description)) !!}</p>
                        </div>

                        <div class="post">
                            <h3>History</h3>
                            <p>{!! nl2br(e($location->history)) !!}</p>
                        </div>
                    </div>
                    <div class="tab-pane" id="character">
                        <table id="characters" class="table table-hover">
                            <tbody><tr>
                                <th>{{ trans('characters.fields.name') }}</th>
                                <th>{{ trans('characters.fields.age') }}</th>
                                <th>{{ trans('characters.fields.race') }}</th>
                                <th>&nbsp;</th>
                            </tr>
                            @foreach ($location->characters()->paginate() as $character)
                                <tr>
                                    <td>{{ $character->name }}</td>
                                    <td>{{ $character->age }}</td>
                                    <td>{{ $character->race }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('characters.show', ['id' => $character->id]) }}" class="btn btn-xs btn-primary">
                                            <i class="fa fa-eye" aria-hidden="true"></i> {{ trans('crud.view') }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>

            <!-- actions -->
        </div>
    </div>
@endsection
