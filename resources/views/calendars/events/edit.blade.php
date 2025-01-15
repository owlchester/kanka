@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('calendars.event.edit.title', ['name' => $entity->name]),
    'breadcrumbs' => isset($next) && $next == 'entity.events' ? [
        $entity->entityType->plural(),
        ['url' => $entity->url(), 'label' => $entity->name],
        __('crud.tabs.reminders'),
        __('crud.update'),
    ] : [
        Breadcrumb::entity($entityEvent->calendar->entity)->list(),
        Breadcrumb::show($entityEvent->calendar),
        __('crud.tabs.reminders'),
        __('crud.update'),
    ],
    'canonical' => true,
    'centered' => true,
])
@section('content')
    <x-form method="PATCH" :action="['entities.entity_events.update', $campaign, $entity->id, $entityEvent->id]" class="entity-calendar-subform">

    @include('partials.forms.form', [
        'title' => __('calendars.event.edit.title', ['name' => '<a href="' . $entity->url() . '">' . $entity->name . '</a>']),
        'content' => 'calendars.events._form',
        'deleteID' => '#delete-reminder-' . $entityEvent->id,
        'dialog' => true,
        'dropdownParent' => request()->ajax() ? '#primary-dialog' : null,
    ])


    @if (!empty($next))
        <input type="hidden" name="next" value="{{ $next }}" />
    @endif
    @if (request()->has('layout'))
        <input type="hidden" name="layout" value="{{ request()->get('layout') }}" />
    @endif
    </x-form>
    <x-form :action="['entities.entity_events.destroy', $campaign, $entity->id, $entityEvent->id]" method="DELETE" id="delete-reminder-{{ $entityEvent->id }}">
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
