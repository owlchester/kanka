@extends('layouts.app', [
    'title' => trans('search.title'),
    'description' => trans('search.description'),
    'breadcrumbs' => [
        trans('search.title'),
    ]
])
@inject('campaign', 'App\Services\CampaignService')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('search.title') }}</h3>
                </div>
                {!! Form::open(array('route' => 'search', 'method'=>'GET')) !!}
                <div class="box-body">
                    <div class="form-group">
                <!-- form start -->
                        <input type="text" name="q" class="form-control" placeholder="Search..." value="{{ request()->get('q') }}">
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="pull-right btn btn-primary"><i class="fa fa-search"></i> {{ trans('crud.search') }}</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    @foreach ($results as $element => $values)
                        @if (count($values) > 0)
                        <li class="{{ ($element == $active ? 'active' : null) }}">
                            <a href="#{{ $element }}" data-toggle="tab" aria-expanded="false">
                                {{ trans('entities.' . $element) }}
                                <span class="badge bg-blue">{{ count($values) }}</span>
                            </a>
                        </li>
                        @endif
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach ($results as $element => $values)
                        @if (!empty($values))
                        <div class="tab-pane {{ (request()->get('tab') == $element || $active == $element ? ' active' : '') }}" id="{{ $element }}">
                            @include($element . '.datagrid', ['models' => $values])
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection