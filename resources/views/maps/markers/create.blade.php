<?php /**
 * @var \App\Models\Map $map
 * @var \App\Models\MapMarker $model
 */?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('maps/markers.create.title', ['name' => $map->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('maps.index'), 'label' => __('maps.index.title')],
        ['url' => $map->entity->url('show'), 'label' => $map->name],
        __('maps/markers.create.title')
    ]
])

@section('content')
    <div class="panel panel-default">
        @if ($ajax)
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4>
                    {{ __('maps/markers.create.title', ['name' => $map->name]) }}
                </h4>
            </div>
        @endif
        <div class="panel-body">
            @include('partials.errors')

            {!! Form::open(['route' => ['maps.map_markers.store', $map],
                'method' => 'POST',
                'data-shortcut' => 1,
                'id' => 'map-marker-form',
                'enctype' => 'multipart/form-data'
               ]) !!}
            @include('maps.markers._form', ['model' => null])

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
