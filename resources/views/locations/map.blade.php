@extends('layouts.app', [
    'title' => trans('locations.map.points.title', ['name' => $location->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('locations.index'), 'label' => trans('locations.index.title')],
        ['url' => route('locations.show', $location->id), 'label' => $location->name]
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p class="help-block">{{ trans('locations.map.helper') }}</p>
                    @include('partials.errors')

                    {!! Form::open(array('route' => ['locations.map', $location->id], 'method'=>'POST', 'data-shortcut' => "1")) !!}

                    <div class="map map-admin" id="location-map-admin">
                        <img src="/storage/{{ $location->map }}" alt="{{ $location->name }}" />
                        @foreach ($location->mapPoints as $point)
                            <div class="point admin" style="top: {{ $point->axis_y }}px; left: {{ $point->axis_x }}px" title="{{ trans('crud.remove') }}">
                                {!! Form::hidden('map_point[' . $point->id  . ']', 1) !!}
                                <i class="fa fa-trash"></i>
                            </div>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <button class="btn btn-success">{{ trans('crud.save') }}</button>
                        {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous() . (strpos(url()->previous(), '?tab=') === false ? '#map' : null))]) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="point-location" tabindex="false" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ trans('locations.map.modal.title') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ trans('crud.fields.location') }}</label>
                            {!! Form::select('location_id', [],
                            null, ['id' => 'location_id', 'class' => 'form-control select2', 'style' => 'width: 100%', 'data-url' => route('locations.find'), 'data-placeholder' => trans('crud.placeholders.location')]) !!}

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('crud.delete_modal.close') }}</button>
                    <button type="button" class="btn btn-primary" id="point-location-submit">{{ trans('locations.map.modal.submit') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
