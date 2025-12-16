@if (!empty($from))
    <x-alert type="warning" class="w-full">
        <p>{!! __('calendars.event.helpers.other_calendar', ['calendar' => '<a href="' . $from->entity?->url() . '" class="text-link">' . $from->name . '</a>']) !!}</p>
    </x-alert>
@endif

@if (!empty($reminder) && $reminder->isEntity())
    <x-grid type="1/1">
        @include('cruds.fields.entity', ['route' => null, 'preset' => $reminder->remindable, 'name' => 'entity_id', 'dropdownParent' => $dropdownParent ?? '#primary-dialog', 'allowClear' => false])
    </x-grid>
@endif

<div id="calendar-event-subform" class="flex flex-col gap-5">
    @if (empty($reminder))
        <div class="flex gap-2 md:gap-4 items-center">
            <div class="grow calendar-existing-event-field">
                @php $eventModule = \App\Models\EntityType::find(config('entities.ids.event')) @endphp
                @include('cruds.fields.entity', [
                    'dropdownParent' => $dropdownParent ?? (request()->ajax() ? '#primary-dialog' : null),
                    'required' => true,
                    'dynamicNew' => auth()->user()->can('create', [$eventModule, $campaign]),
                    'dynamicTag' => __('crud.titles.new', ['module' => $eventModule->name()])
                ])
            </div>
        </div>
    @endif
    @include('calendars.reminders._subform')
</div>
