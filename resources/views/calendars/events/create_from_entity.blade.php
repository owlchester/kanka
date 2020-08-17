@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans('calendars.event.create.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('calendars.index'), 'label' => trans('calendars.index.title')],
        ['url' => $entity->url(), 'label' => $entity->name],
        ['url' => $entity->url() . '#calendars', 'label' => trans('crud.tabs.events')],
        trans('crud.tabs.reminders'),
    ],
    'canonical' => true,
])
@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            @include('partials.errors')

            {!! Form::open(['method' => 'POST', 'route' => ['entities.entity_events.store', $entity->id], 'data-shortcut' => "1"]) !!}
            @include('calendars.events._entity_form')

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
            </div>
        </div>

    </div>
@endsection
