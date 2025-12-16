@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('calendars.event.edit.title', ['name' => $entity->name]),
    'breadcrumbs' => isset($next) && $next == 'entity.reminders' ? [
        $entity->entityType->plural(),
        ['url' => $entity->url(), 'label' => $entity->name],
        __('crud.tabs.reminders'),
        __('crud.update'),
    ] : [
        Breadcrumb::campaign($campaign)->entity($reminder->calendar->entity)->list(),
        Breadcrumb::show(),
        __('crud.tabs.reminders'),
        __('crud.update'),
    ],
    'canonical' => true,
    'centered' => true,
])
@section('content')
    <x-form method="PATCH" :action="['reminders.update', $campaign, $reminder->id]" class="entity-calendar-subform">

    @include('partials.forms._dialog', [
        'title' => __('calendars.event.edit.title', ['name' => '<a href="' . $entity->url() . '" class="text-link">' . $entity->name . '</a>']),
        'content' => 'calendars.reminders._form',
        'deleteID' => '#delete-reminder-' . $reminder->id,
        'dropdownParent' => request()->ajax() ? '#primary-dialog' : null,
    ])


    @if (!empty($next))
        <input type="hidden" name="next" value="{{ $next }}" />
    @endif
    @if (request()->has('layout'))
        <input type="hidden" name="layout" value="{{ request()->get('layout') }}" />
    @endif
    </x-form>
    <x-form :action="['reminders.destroy', $campaign, $reminder->id]" method="DELETE" id="delete-reminder-{{ $reminder->id }}">
    @if (request()->has('layout'))
        <input type="hidden" name="layout" value="{{ request()->get('layout') }}" />
    @endif
    @if (!empty($from))
        <input type="hidden" name="from" value="{{ $from }}" />
    @endif
    @if (!empty($next))
        <input type="hidden" name="next" value="{{ $next }}" />
    @endif
    </x-form>
@endsection
