@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('calendars.event.create.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('calendars.index'), 'label' => __('calendars.index.title')],
        ['url' => $entity->url(), 'label' => $entity->name],
        ['url' => $entity->url() . '#calendars', 'label' => __('crud.tabs.events')],
        __('crud.tabs.reminders'),
    ],
    'canonical' => true,
])
@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            @include('partials.errors')

            {!! Form::open(['method' => 'POST', 'route' => ['entities.entity_events.store', $entity->id], 'data-shortcut' => 1, 'class' => 'ajax-validation']) !!}
            @include('calendars.events._entity_form')

            {!! Form::hidden('entity_id', $entity->id) !!}

            <div class="row">
                <div class="col-md-6 pull-right text-right ">
                    <div class="form-group text-right">
                        <button class="btn btn-success" id="calendar-event-submit">
                            <i class="fa fa-spinner fa-spin" style="display:none;"></i>
                            <span>{{ __('crud.save') }}</span>
                        </button>
                        @includeWhen(!$ajax, 'partials.or_cancel')
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
