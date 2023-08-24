
<div class="field-attitude">
    <label for="attitude">
        {{ __('entities/relations.fields.attitude') }}
        <x-helpers.tooltip :title="__('entities/relations.hints.attitude')"/>
    </label>
    {!! Form::number('attitude', null, ['placeholder' => __('entities/relations.placeholders.attitude'), 'class' => 'form-control', 'min' => -100, 'max' => 100]) !!}
    <p class="help-block visible-xs visible-sm">{{ __('entities/relations.hints.attitude') }}</p>
</div>
