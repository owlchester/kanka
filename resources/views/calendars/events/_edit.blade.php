<div class="panel-body">
    @include('partials.errors')

    {!! Form::model($entityEvent, ['method' => 'PATCH', 'route' => ['entities.entity_events.update', $entity->id, $entityEvent->id], 'data-shortcut' => "1"]) !!}
    @include('calendars.events._form')

    <div class="row">
        <div class="col-md-6 pull-right text-right">
            <div class="form-group text-right">
                <button class="btn btn-success">{{ trans('crud.save') }}</button>
                @if (!$ajax)
                {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
                @endif
            </div>
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
