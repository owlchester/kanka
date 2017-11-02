@extends('layouts.app', [
    'title' => trans('journals.index.title'),
    'description' => trans('journals.index.description'),
    'breadcrumbs' => [
        ['url' => route('journals.index'), 'label' => trans('journals.index.title')]
    ]
])
@inject('campaign', 'App\Services\CampaignService')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <a href="{{ route('journals.create') }}" class="btn btn-primary btn-block margin-bottom">{{ trans('journals.index.add') }}</a>

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
                    <h3>{{ trans('journals.index.header', ['name' => $campaign->name()]) }}</h3>
                </div>

                <div class="box-body table-responsive no-padding">

                    @include('layouts.datagrid.search', ['route' => route('journals.index')])
                    <table id="journals" class="table table-hover">
                        <tbody><tr>
                            <th><a href="{{ route('journals.index', ['order' => 'name', 'page' => request()->get('page')]) }}">{{ trans('journals.fields.name') }}</a></th>
                            <th><a href="{{ route('journals.index', ['order' => 'type', 'page' => request()->get('page')]) }}">{{ trans('journals.fields.type') }}</a></th>
                            <th><a href="{{ route('journals.index', ['order' => 'date', 'page' => request()->get('page')]) }}">{{ trans('journals.fields.date') }}</a></th>
                            <th>&nbsp;</th>
                        </tr>
                        @foreach ($models as $model)
                        <tr>
                            <td>
                                <a href="{{ route('journals.show', $model->id) }}">{{ $model->name }}</a>
                            </td>
                            <td>{{ $model->type }}</td>
                            <td>{{ $model->date }}</td>
                            <td class="text-right">
                                <a href="{{ route('journals.show', ['id' => $model->id]) }}" class="btn btn-xs btn-primary">
                                    <i class="fa fa-eye" aria-hidden="true"></i> {{ trans('crud.view') }}
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody></table>

                    {{ $models->appends('order', request()->get('order'))->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
