{{ csrf_field() }}
@if (empty($entityEvent))
    <div class="row" id="calendar-event-first">
        <div class="col-md-6">
            <span class="calendar-event-action" id="calendar-action-existing">
                <i class="ra ra-eyeball"></i> {{ __('calendars.event.actions.existing') }}
            </span>
        </div>
        <div class="col-md-6">
            <span class="calendar-event-action" id="calendar-action-new">
                <i class="far fa-calendar"></i> {{ __('calendars.event.actions.new') }}
            </span>
        </div>
    </div>
@else
    @include('cruds.fields.entity', ['entity' => $entityEvent->entity])
@endif

<div id="calendar-event-subform" style="{{ empty($entityEvent) ? 'display:none' : null }}">
    @if (empty($entityEvent))
        <div class="row">
            <div class="col-md-8 calendar-existing-event-field">
                {!! Form::select2(
                    'entity_id',
                    null,
                    App\Models\Entity::class,
                    false,
                    'crud.fields.entity',
                    'search.entities-with-reminders'
                ) !!}
            </div>
            <div class="col-md-8 calendar-new-event-field">
                <div class="form-group">
                    <label>{{ __('events.fields.name') }}</label>
                    {!! Form::text('name', null, ['placeholder' => __('events.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
            </div>
            <div class="col-md-4">
            <span class="pull-right">
                <label></label>
                <a href="#" id="calendar-event-switch" class="pull-right">
                    {{ __('calendars.event.actions.switch') }}
                </a>
            </span>
            </div>
        </div>
    @endif
    @include('calendars.events._subform')
</div>