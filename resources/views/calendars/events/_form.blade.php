@if (!empty($from))
    <x-alert type="warning">
        {!! __('calendars.event.helpers.other_calendar', ['calendar' => $from->tooltipedLink()]) !!}
    </x-alert>
@endif

@if (empty($entityEvent))
    <x-grid id="calendar-event-first">
        <a href="#" class="btn2 text-2" id="calendar-action-existing">
            <x-icon class="fa-solid fa-search fa-2x" />
            {{ __('calendars.event.actions.existing') }}
        </a>

        <span class="btn2" id="calendar-action-new">
            <x-icon class="fa-solid fa-bolt fa-2x" />
            {{ __('calendars.event.actions.new') }}
        </span>
    </x-grid>
@else
    <x-grid type="1/1">
        @include('cruds.fields.entity', ['route' => null, 'preset' => $entityEvent->entity, 'name' => 'entity_id', 'dropdownParent' => $dropdownParent ?? '#primary-dialog', 'allowClear' => false])
    </x-grid>
@endif

<div id="calendar-event-subform" class="flex flex-col gap-5 {{ empty($entityEvent) ? 'hidden' : null }}">
    @if (empty($entityEvent))
        <div class="flex gap-2 md:gap-4 items-center">
            <div class="grow calendar-existing-event-field">
                @include('cruds.fields.entity', [
                    'dropdownParent' => $dropdownParent ?? (request()->ajax() ? '#primary-dialog' : null),
                    'required' => true
                ])
            </div>
            <div class="grow calendar-new-event-field">
                <x-forms.field
                    field="name"
                    :label="__('crud.fields.name')">
                    <input type="text" name="name" placeholder="{{ __('crud.placeholders.name') }}" maxlength="191" value="{!! htmlspecialchars(old('name', $source->name ?? $model->name ?? null)) !!}" />
                </x-forms.field>
            </div>
            <div class="self-start">
                <a href="#" id="calendar-event-switch" class="btn2 btn-xs">
                    <x-icon class="fa-solid fa-exchange-alt" />
                    {{ __('calendars.event.actions.switch') }}
                </a>
            </div>
        </div>
    @endif
    @include('calendars.events._subform')
</div>
