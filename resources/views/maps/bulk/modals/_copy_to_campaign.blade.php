<div class="form-group">
    <label>{!! Form::checkbox('copy_related_elements', 1, true) !!}
        {{ __('maps/markers.fields.copy_elements') }}
    </label>
    <p class="help-block">
        {{ __('maps/markers.helpers.copy_elements_to_campaign') }}
    </p>
</div>
