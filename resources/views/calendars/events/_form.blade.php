{{ csrf_field() }}
@if (empty($entityEvent))
    <x-grid id="calendar-event-first">
        <a href="#" class="btn2 text-2" id="calendar-action-existing">
            <i class="fa-solid fa-search fa-2x"></i>
            {{ __('calendars.event.actions.existing') }}
        </a>

        <span class="btn2" id="calendar-action-new">
            <i class="fa-solid fa-bolt fa-2x"></i>
            {{ __('calendars.event.actions.new') }}
        </span>
    </x-grid>
@else
    <div class="field-entity">
        @include('cruds.fields.entity', ['route' => null, 'preset' => $entityEvent->entity, 'name' => 'entity_id'])
    </div>
@endif

<div id="calendar-event-subform" style="{{ empty($entityEvent) ? 'display:none' : null }}">
    @if (empty($entityEvent))
        <div class="flex gap-2 md:gap-4 mb-2 md:mb-4 items-center">
            <div class="grow calendar-existing-event-field">
                @include('cruds.fields.entity', [
                    'dropdownParent' => request()->ajax() ? '#entity-modal' : null,
                    'required' => true
                ])
            </div>
            <div class="grow calendar-new-event-field">
                <div class="field-name">
                    <label>{{ __('crud.fields.name') }}</label>
                    {!! Form::text('name', null, ['placeholder' => __('crud.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
            </div>
            <div class="">
                <a href="#" id="calendar-event-switch" class="btn2 btn-sm">
                    {{ __('calendars.event.actions.switch') }}
                </a>
            </div>
        </div>
    @endif
    @include('calendars.events._subform')
</div>
