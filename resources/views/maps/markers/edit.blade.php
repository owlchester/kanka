<?php /**
 * @var \App\Models\Map $map
 * @var \App\Models\MapMarker $model
 */?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('maps/markers.edit.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('maps.index'), 'label' => __('maps.index.title')],
        ['url' => $map->entity->url('show'), 'label' => $map->name],
        __('maps/markers.edit.title', ['name' => $model->name])
    ]
])

@section('content')
    <div class="panel panel-default">
        @if ($ajax)
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4>
                    {{ __('maps/markers.edit.title', ['name' => $model->name]) }}
                </h4>
            </div>
        @endif
        <div class="panel-body">
            @include('partials.errors')

            {!! Form::model($model, ['route' => ['maps.map_markers.update', 'map' => $map, 'map_marker' => $model],
                'method' => 'PATCH',
                'data-shortcut' => 1,
                'enctype' => 'multipart/form-data'
               ]) !!}
            @include('maps.markers._form')

            <div class="form-group">
                <button class="btn btn-success">{{ trans('crud.save') }}</button>
                @if (!$ajax)
                    {!! __('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
                @endif
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection
