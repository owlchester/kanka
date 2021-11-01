@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
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

    {!! Form::open(['method' => 'POST', 'route' => ['entities.entity_events.store', $entity->id], 'data-shortcut' => 1, 'class' => 'ajax-validation']) !!}

    <div class="panel panel-default">
        <div class="panel-body">
            @include('partials.errors')

            @include('calendars.events._entity_form')

            {!! Form::hidden('entity_id', $entity->id) !!}

        </div>
        <div class="panel-footer">
            <div class="pull-right">
                <button class="btn btn-success" id="calendar-event-submit">
                    <i class="fa fa-spinner fa-spin" style="display:none;"></i>
                    <span>{{ __('crud.save') }}</span>
                </button>
            </div>

            @include('partials.footer_cancel')
        </div>
    </div>

    @if (!empty($next))
        <input type="hidden" name="next" value="{{ $next }}" />
    @endif
    {!! Form::close() !!}
@endsection
