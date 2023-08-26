@php
    $pinnedOptions = [
        0 => __('pins.options.no'),
        1 => __('pins.options.yes')
    ];
@endphp
<div class="field-pinned">
    <label>
        {{ __('crud.fields.is_star') }}
        <a href="https://docs.kanka.io/en/latest/features/profile-sidebar/how-to-pin-elements.html" target="_blank">
            <x-helpers.tooltip :title="__('crud.hints.is_star')" />
            <span class="sr-only">{{ __('pins.learn-more') }}</span>
        </a>
    </label>
    {!! Form::select('is_pinned', $pinnedOptions, !empty($model) ? $model->isPinned() : 0, ['class' => 'form-control']) !!}
    <p class="help-block visible-xs visible-sm">{{ __('crud.hints.is_star') }}</p>
</div>
