@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('calendars.event.create.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('calendars.index', $campaign), 'label' => __('entities.calendars')],
        ['url' => $entity->url(), 'label' => $entity->name],
        __('crud.tabs.reminders'),
    ],
    'canonical' => true,
])
@section('content')

    {!! Form::open([
        'method' => 'POST',
        'route' => ['entities.entity_events.store', [$campaign, $entity]],
        'data-shortcut' => 1,
        'class' => 'ajax-validation',
        'data-maintenance' => 1,
    ]) !!}

    @if (request()->ajax())
        <div class="modal-body">

            @include('partials.errors')

            @include('calendars.events._entity_form')
        </div>
        <div class="modal-footer">
            <button class="btn btn-success" id="calendar-event-submit">
                <i class="fa-solid fa-spinner fa-spin" style="display:none;"></i>
                <span>{{ __('crud.save') }}</span>
            </button>
            <div class="pull-left">
                @include('partials.footer_cancel')
            </div>
        </div>
    @else

        <div class="panel panel-default">
            <div class="panel-body">
                @include('partials.errors')
                @include('calendars.events._entity_form')
            </div>
            <div class="panel-footer">
                <div class="pull-right">
                    <button class="btn btn-success" id="calendar-event-submit">
                        <i class="fa-solid fa-spinner fa-spin" style="display:none;"></i>
                        <span>{{ __('crud.save') }}</span>
                    </button>
                </div>

                @include('partials.footer_cancel')
            </div>
        </div>
    @endif

    {!! Form::hidden('entity_id', $entity->id) !!}
    @if (!empty($next))
        <input type="hidden" name="next" value="{{ $next }}" />
    @endif
    {!! Form::close() !!}
@endsection
