<div class="row">
    <div class="col-md-8 calendar-existing-event-field">
        {!! Form::select2(
            'entity_id',
            null,
            App\Models\Entity::class,
            false,
            'crud.fields.entity',
            'search.calendar_event'
        ) !!}
    </div>
    <div class="col-md-8 calendar-new-event-field">
        <div class="form-group">
            <label>{{ trans('events.fields.name') }}</label>
            {!! Form::text('name', null, ['placeholder' => trans('events.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
    </div>
    <div class="col-md-4">
                            <span class="pull-right">
                                <label></label>
                                <a href="#" id="calendar-event-switch" class="pull-right">
                                    {{ trans('calendars.event.actions.switch') }}
                                </a>
                            </span>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>{{ trans('calendars.fields.comment') }}</label>
            {!! Form::text('comment', null, ['placeholder' => trans('calendars.placeholders.comment'), 'class' => 'form-control', 'maxlength' => 45]) !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>
                {!! Form::checkbox('is_recurring') !!}
                {{ trans('calendars.fields.is_recurring') }}
            </label>
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-group" style="display:none" id="add_event_recurring_until">
            <label>{{ trans('calendars.fields.recurring_until') }}</label>
            {!! Form::text('recurring_until', null, ['placeholder' => trans('calendars.placeholders.recurring_until'), 'class' => 'form-control', 'maxlength' => 12]) !!}
        </div>
    </div>
    <div class="col-md-12">
        <p class="help-block">{{ trans('calendars.hints.is_recurring') }}</p>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ trans('calendars.fields.length') }}</label>
            {!! Form::number('length', 1, ['placeholder' => trans('calendars.placeholders.length'), 'class' => 'form-control', 'maxlength' => 1]) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ trans('calendars.fields.colour') }}</label>
            {!! Form::select('colour', trans('calendars.colours'), null, ['placeholder' => trans('calendars.placeholders.colour'), 'class' => 'form-control']) !!}
        </div>
    </div>
</div>