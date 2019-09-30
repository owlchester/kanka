<?php
/** @var \App\Models\MapPoint $model */
?>@extends((isset($ajax) && $ajax ? 'layouts.ajax' : 'layouts.app'), [
    'title' => trans('locations.map_points.edit.title', ['name' => $location->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('locations'), 'label' => trans('locations.index.title')],
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
        <a class="pull-right btn btn-default"
           data-toggle="popover" data-html="true" data-placement="top"
           data-content="<p>{{ __('locations.map.actions.confirm_delete') }}</p>
           <a href='{{ route('locations.map_points.destroy', [$location, $model]) }}' class='btn btn-block btn-danger map-point-delete'>{{ __('crud.click_modal.confirm') }}</a>"
            title="{{ __('crud.remove') }}"
        >
            <i class="fa fa-trash"></i> {{ trans('crud.remove') }}
        </a>
        @endif
    </div>

    {!! Form::close() !!}



@endsection
