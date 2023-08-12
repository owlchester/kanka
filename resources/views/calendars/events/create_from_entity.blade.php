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
        'route' => ['entities.entity_events.store', $campaign, $entity->id],
        'data-shortcut' => 1,
        'class' => 'ajax-validation',
        'data-maintenance' => 1,
    ]) !!}

    @if (request()->ajax())
        <div class="modal-body">

            @include('partials.errors')

            @include('calendars.events._entity_form')

            <x-dialog.footer :modal="true">
                <button class="btn2 btn-primary" id="calendar-event-submit">
                    <i class="fa-solid fa-spinner fa-spin" style="display:none;"></i>
                    <span>{{ __('crud.save') }}</span>
                </button>
            </x-dialog.footer>
        </div>
    @else
        <x-box>
            @include('partials.errors')
            @include('calendars.events._entity_form')

            <x-dialog.footer>
                <button class="btn2 btn-primary" id="calendar-event-submit">
                    <i class="fa-solid fa-spinner fa-spin" style="display:none;"></i>
                    <span>{{ __('crud.save') }}</span>
                </button>
            </x-dialog.footer>
        </x-box>
    @endif

    {!! Form::hidden('entity_id', $entity->id) !!}
    @if (!empty($next))
        <input type="hidden" name="next" value="{{ $next }}" />
    @endif
    {!! Form::close() !!}
@endsection
