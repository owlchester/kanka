
<div class="form-group">
    <label for="attitude">
        {{ __('entities/relations.fields.attitude') }}
        <i class="fa-solid fa-question-circle hidden-xs hidden-sm" title="{{ __('entities/relations.hints.attitude') }}" data-toggle="tooltip"></i>
    </label>
    {!! Form::number('attitude', null, ['placeholder' => __('entities/relations.placeholders.attitude'), 'class' => 'form-control', 'min' => -100, 'max' => 100]) !!}
    <p class="help-block visible-xs visible-sm">{{ __('entities/relations.hints.attitude') }}</p>
</div>
