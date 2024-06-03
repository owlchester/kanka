@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('calendars.event.create.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('calendars.index', $campaign), 'label' => __('entities.calendars')],
        ['url' => $entity->url(), 'label' => $entity->name],
        __('crud.tabs.reminders'),
    ],
    'canonical' => true,
    'centered' => true,
])
@section('content')

    {!! Form::open([
        'method' => 'POST',
        'route' => ['entities.entity_events.store', $campaign, $entity->id],
        'data-shortcut' => 1,
        'class' => 'ajax-subform',
        'data-maintenance' => 1,
    ]) !!}

    @include('partials.forms.form', [
        'title' => __('calendars.event.create.title', ['name' => $entity->name]),
        'content' => 'calendars.events._entity_form',
        'dialog' => true,
        'dropdownParent' => request()->ajax() ? '#primary-dialog' : null,
    ])

    <input type="hidden" name="entity_id" value="{{ $entity->id }}" />
    @if (!empty($next))
        <input type="hidden" name="next" value="{{ $next }}" />
    @endif
    {!! Form::close() !!}
@endsection
