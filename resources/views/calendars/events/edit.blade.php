@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('calendars.event.edit.title', ['name' => $entity->name]),
    'breadcrumbs' => isset($next) && $next == 'entity.events' ? [
        __('entities.' . $entity->pluralType()),
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
    {!! Form::model($entityEvent, [
    'method' => 'PATCH',
    'route' => ['entities.entity_events.update', $campaign, $entity->id, $entityEvent->id],
    'data-shortcut' => '1',
    'class' => 'ajax-subform entity-calendar-subform',
    'data-maintenance' => 1
 ]) !!}

    @include('partials.forms.form', [
        'title' => __('calendars.event.edit.title', ['name' => link_to($entity->url(), $entity->name)]),
        'content' => 'calendars.events._form',
        'deleteID' => '#delete-reminder-' . $entityEvent->id,
        'dialog' => true,
        'dropdownParent' => '#primary-dialog',
    ])


    @if (!empty($next))
        <input type="hidden" name="next" value="{{ $next }}" />
    @endif
    @if (request()->has('layout'))
        {!! Form::hidden('layout', request()->get('layout')) !!}
    @endif
    {!! Form::close() !!}

    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['entities.entity_events.destroy', $campaign, $entity->id, $entityEvent->id],
        'id' => 'delete-reminder-' . $entityEvent->id]) !!}
    @if (request()->has('layout'))
        {!! Form::hidden('layout', request()->get('layout')) !!}
    @endif
    @if (!empty($from))
        {!! Form::hidden('from', $from) !!}
    @endif
    @if (!empty($next))
        {!! Form::hidden('next', $next) !!}
    @endif
    {!! Form::close() !!}
@endsection
