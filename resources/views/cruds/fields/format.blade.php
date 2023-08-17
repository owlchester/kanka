<div class="field-format">
    <label>
        {{ __('calendars.fields.format') }}
        <i class="fa-solid fa-question-circle hidden-xs hidden-sm" aria-hidden="true" data-toggle="tooltip" data-title="{{ __('calendars.helpers.format', ['format' => __('calendars.helpers.custom_format')]) }}" href="https://docs.kanka.io/en/latest/entities/calendars.html#date-format"></i>
    </label>
    {!! Form::text('format', $model->format, ['class' => 'form-control']) !!}
    <p class="help-block visible-xs visible-sm">
        {!! __('calendars.helpers.format', ['format' => link_to('https://docs.kanka.io/en/latest/entities/calendars.html#date-format', __('calendars.helpers.custom_format'), null, ['target' => '_blank'])]) !!}
    </p>
</div>
