@extends('layouts.app', [
    'title' => trans('families.index.title'),
    'description' => trans('families.index.description'),
    'breadcrumbs' => [
        ['url' => route('families.index'), 'label' => trans('families.index.title')]
    ]
])
@inject('campaign', 'App\Services\CampaignService')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <a href="{{ route('families.create') }}" class="btn btn-primary btn-block margin-bottom">{{ trans('families.index.add') }}</a>

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
                    <h3>{{ trans('families.index.header', ['name' => $campaign->name()]) }}</h3>
                </div>

                <div class="box-body table-responsive no-padding">
                    @include('layouts.datagrid.search', ['route' => route('families.index')])

                    <table id="families" class="table table-hover">
                        <tbody><tr>
                            <th><br></th>
                            <th><a href="{{ route('families.index', ['order' => 'name', 'page' => request()->get('page')]) }}">{{ trans('families.fields.name') }}</a></th>
                            <th>{{ trans('families.fields.location') }}</th>
                            <th>{{ trans('families.fields.members') }}</th>
                            <th>&nbsp;</th>
                        </tr>
                        @foreach ($models as $family)
                        <tr>
                            <td>
                                @if ($family->image)
                                    <img class="direct-chat-img" src="/storage/{{ $family->image }}" alt="{{ $family->name }} picture">
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('families.show', $family->id) }}">{{ $family->name }}</a>
                            </td>
                            <td>
                                @if ($family->location)
                                    <a href="{{ route('locations.show', $family->location_id) }}">{{ $family->location->name }}</a>
                                @endif
                            </td>
                            <td>
                                {{ $family->members()->count() }}
                            </td>
                            <td class="text-right">
                                <a href="{{ route('families.show', ['id' => $family->id]) }}" class="btn btn-xs btn-primary">
                                    <i class="fa fa-eye" aria-hidden="true"></i> {{ trans('crud.view') }}
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody></table>

                    {{ $models->appends(['order' => request()->get('order')])->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
