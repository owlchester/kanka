
<div class="form-group">
    {!! Form::hidden('is_pinned', 0) !!}
    <label>
        {!! Form::checkbox('is_pinned', 1, !empty($model) ? $model->is_pinned : 0) !!}
        {{ __('crud.fields.is_star') }}
        <i class="fa-solid fa-question-circle hidden-xs hidden-sm" title="{{ __('crud.hints.is_star') }}" data-toggle="tooltip"></i>
    </label>
    <p class="help-block visible-xs visible-sm">{{ __('crud.hints.is_star') }}</p>
</div>
