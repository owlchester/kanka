@extends('layouts.app', ['title' => trans('locations.index.title'), 'description' => trans('locations.index.description')])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <a href="{{ route('locations.create') }}" class="btn btn-primary btn-block margin-bottom">{{ trans('locations.index.add') }}</a>

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
                    <h3>{{ trans('locations.index.header', ['name' => $campaign->name()]) }}</h3>
                </div>

                <div class="box-body table-responsive no-padding">

                    @include('layouts.datagrid.search', ['route' => route('locations.index')])
                    <table id="locations" class="table table-hover">
                        <tbody><tr>
                            <th>{{ trans('locations.fields.id') }}</th>
                            <th>{{ trans('locations.fields.name') }}</th>
                            <th>{{ trans('locations.fields.type') }}</th>
                            <th>{{ trans('locations.fields.location') }}</th>
                            <th>&nbsp;</th>
                        </tr>
                        @foreach ($models as $model)
                        <tr>
                            <td>{{ $model->id }}</td>
                            <td>{{ $model->name }}</td>
                            <td>{{ $model->type }}</td>
                            <td>
                                @if ($model->parentLocation)
                                    <a href="{{ route('locations.show', $model->parentLocation->id) }}">{{ $model->parentLocation->name }}</a>
                                @endif
                            </td>
                            <td class="text-right">
                                <a href="{{ route('locations.show', ['id' => $model->id]) }}" class="btn btn-xs btn-primary">
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
