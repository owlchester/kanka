@extends('layouts.app', ['title' => trans('characters.index.title'), 'description' => trans('characters.index.description')])
@inject('campaign', 'App\Services\CampaignService')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <a href="{{ route('characters.create') }}" class="btn btn-primary btn-block margin-bottom">{{ trans('characters.index.add') }}</a>

            <!--
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Filters</h3>

                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                        <li class="active"><a href="#"><i class="fa fa-inbox"></i> Inbox
                                <span class="label label-primary pull-right">12</span></a></li>
                        <li><a href="#"><i class="fa fa-envelope-o"></i> Sent</a></li>
                        <li><a href="#"><i class="fa fa-file-text-o"></i> Drafts</a></li>
                        <li><a href="#"><i class="fa fa-filter"></i> Junk <span class="label label-warning pull-right">65</span></a>
                        </li>
                        <li><a href="#"><i class="fa fa-trash-o"></i> Trash</a></li>
                    </ul>
                </div>
            </div>
                -->
            <!-- /.box -->
        </div>

        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3>{{ trans('characters.index.header', ['name' => $campaign->name()]) }}</h3>
                </div>

                <div class="box-body table-responsive no-padding">
                    @include('layouts.datagrid.search', ['route' => route('characters.index')])

                    <table id="characters" class="table table-hover">
                        <tbody><tr>
                            <th>{{ trans('characters.fields.id') }}</th>
                            <th>{{ trans('characters.fields.name') }}</th>
                            <th>{{ trans('characters.fields.location') }}</th>
                            <th>{{ trans('characters.fields.age') }}</th>
                            <th>{{ trans('characters.fields.race') }}</th>
                            <th>{{ trans('characters.fields.sex') }}</th>
                            <th>&nbsp;</th>
                        </tr>
                        @foreach ($models as $character)
                        <tr>
                            <td>{{ $character->id }}</td>
                            <td>{{ $character->name }}</td>
                            <td>
                                @if ($character->location)
                                    <a href="{{ route('locations.show', $character->location_id) }}">{{ $character->location->name }}</a>
                                @endif
                            </td>
                            <td>{{ $character->age }}</td>
                            <td>{{ $character->race }}</td>
                            <td>{{ $character->sex }}</td>
                            <td class="text-right">
                                <a href="{{ route('characters.show', ['id' => $character->id]) }}" class="btn btn-xs btn-primary">
                                    <i class="fa fa-eye" aria-hidden="true"></i> {{ trans('crud.view') }}
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody></table>

                    {{ $models->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
