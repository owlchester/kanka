@extends('layouts.app', [
    'title' => trans('search.title'),
    'description' => trans('search.description'),
    'breadcrumbs' => [
        trans('search.title'),
    ]
])
@inject('campaign', 'App\Services\CampaignService')

@section('content')
    {!! Form::open(array('route' => 'search', 'method'=>'GET')) !!}

            <div class="box box-solid">
                <div class="box-body">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search..." value="{{ request()->get('q') }}">

                        <div class="input-group-btn">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-search"></i> {{ trans('crud.search') }}
                        </button>
                        </div>
                    </div>
                </div>
            </div>
    {!! Form::close() !!}

    <div class="row">
        @foreach ($results as $element => $values)
            @if (!empty($values) && count($values) > 0)
                @if ($element == 'characters')
                    <div class="col-md-12">
                @else
                    <div class="col-md-6">
                @endif
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                {{ trans('entities.' . $element) }}
                                <span class="badge bg-blue">{{ count($values) }}</span>
                            </h3>
                        </div>
                        <div class="box-body">
                            @include($element . '.datagrid', ['models' => $values])
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endsection