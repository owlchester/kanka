
<div class="form-group">
    {!! Form::hidden('is_star', 0) !!}
    <label>
        {!! Form::checkbox('is_star', 1, !empty($model) ? $model->is_star : 0) !!}
        {{ __('crud.fields.is_star') }}
        <i class="fa-solid fa-question-circle hidden-xs hidden-sm" title="{{ __('crud.hints.is_star') }}" data-toggle="tooltip"></i>
    </label>
    <p class="help-block visible-xs visible-sm">{{ __('crud.hints.is_star') }}</p>
</div>
