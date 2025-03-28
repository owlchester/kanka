@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('calendars.event.create.title', ['name' => $entity->name]),
    'breadcrumbs' => [
        ['url' => route('calendars.index', $campaign), 'label' => __('entities.calendars')],
        ['url' => $entity->url(), 'label' => $entity->name],
        __('crud.tabs.reminders'),
    ],
    'canonical' => true,
    'centered' => true,
])
@section('content')

    <x-form :action="['entities.reminders.store', $campaign, $entity->id]" class="">

    @include('partials.forms._dialog', [
        'title' => __('calendars.event.create.title', ['name' => $entity->name]),
        'content' => 'calendars.reminders._entity_form',
        'dropdownParent' => request()->ajax() ? '#primary-dialog' : null,
    ])

    <input type="hidden" name="entity_id" value="{{ $entity->id }}" />
    @if (!empty($next))
        <input type="hidden" name="next" value="{{ $next }}" />
    @endif
    </x-form>
@endsection
