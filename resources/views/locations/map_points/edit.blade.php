<?php
/** @var \App\Models\MapPoint $model */
?>@extends((isset($ajax) && $ajax ? 'layouts.ajax' : 'layouts.app'), [
    'title' => trans('locations.map_points.edit.title', ['name' => $location->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('locations.index'), 'label' => trans('locations.index.title')],
        ['url' => route('locations.show', [$location, '#map']), 'label' => $location->name]
    ]
])

@section('content')
    @include('partials.errors')

    {!! Form::model($model, ['route' => ['locations.map_points.update', $location, $model], 'method'=>'PATCH', 'data-shortcut' => '1', 'class' => 'map-point-form']) !!}
    @include('locations.map_points._form')

    <div class="form-group">
        <button class="btn btn-success">{{ trans('crud.save') }}</button>
        @if(!isset($ajax))
        {!! trans('crud.or_cancel', ['url' => route('locations.map_points.index', [$location])]) !!}
        @else
        <a class="pull-right btn btn-danger delete-confirm"
            data-toggle="modal" data-name="{{ $model->label() }}"
            data-target="#delete-confirm" data-delete-target="delete-form-{{ $model->id }}"
            title="{{ __('crud.remove') }}"
        >
            <i class="fa fa-trash"></i> {{ trans('crud.remove') }}
        </a>
        @endif
    </div>

    {!! Form::close() !!}


    {!! Form::open(['method' => 'DELETE', 'route' => ['locations.map_points.destroy', 'location' => $location, 'point' => $model],
    'style '=> 'display:inline', 'id' => 'delete-form-' . $model->id, 'class' => 'map-point-delete-form']) !!}
    {!! Form::close() !!}
@endsection
