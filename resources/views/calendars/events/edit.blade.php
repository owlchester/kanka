@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans('calendars.event.edit.title', ['name' => $entity->name]),
    'description' => trans('calendars.event.edit.description'),
    'breadcrumbs' => [
        ['url' => route('calendars.index'), 'label' => trans('calendars.index.title')],
        ['url' => route('calendars.show', $entity->id), 'label' => $entity->name],
        trans('crud.tabs.events'),
        trans('crud.update'),
    ],
    'canonical' => true,
])
@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            @include('partials.errors')

            {!! Form::model($entityEvent, ['method' => 'PATCH', 'route' => ['entities.entity_events.update', $entity->id, $entityEvent->id], 'data-shortcut' => '1']) !!}
            @include('calendars.events._form')

            <div class="row">
                <div class="col-md-6 pull-right text-right ">
                    <div class="form-group text-right">
                        <button class="btn btn-success">{{ trans('crud.save') }}</button>
                        @if (!$ajax)
                            {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
                        @endif
                    </div>

                    @if (!empty($next))
                        <input type="hidden" name="next" value="{{ $next }}" />
                    @endif
                    {!! Form::close() !!}
                </div>
                <div class="col-md-6">
                    {!! Form::open(['method' => 'DELETE', 'route' => ['entities.entity_events.destroy', $entity->id, $entityEvent->id], 'style'=>'display:inline']) !!}
                    <button class="btn btn-danger">
                        <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                    </button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

    </div>
@endsection
