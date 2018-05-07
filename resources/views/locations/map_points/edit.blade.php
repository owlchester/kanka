@extends((isset($ajax) && $ajax ? 'layouts.ajax' : 'layouts.app'), [
    'title' => trans('locations.map_points.edit.title', ['name' => $location->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('locations.index'), 'label' => trans('locations.index.title')],
        ['url' => route('locations.show', [$location, '#map']), 'label' => $location->name]
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::model($model, ['route' => ['locations.map_points.update', $location, $model], 'method'=>'PATCH', 'data-shortcut' => "1"]) !!}                    @include('locations.map_points._form')

                    <div class="form-group">
                        <button class="btn btn-success">{{ trans('crud.save') }}</button>
                        @if(!isset($ajax))
                        {!! trans('crud.or_cancel', ['url' => route('locations.map_points.index', [$location])]) !!}
                        @else
                        <button name="remove" class="pull-right btn btn-danger"><i class="fa fa-trash"></i> {{ trans('crud.remove') }}</button>
                        @endif
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
