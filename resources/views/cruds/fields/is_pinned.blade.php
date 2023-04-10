@php
    $pinnedOptions = [
        0 => __('pins.options.no'),
        1 => __('pins.options.yes')
    ];
@endphp
<div class="form-group">
    <label>
        {{ __('crud.fields.is_star') }}
        <a href="https://docs.kanka.io/en/latest/features/profile-sidebar/how-to-pin-elements.html" target="_blank">
            <i class="fa-solid fa-question-circle hidden-xs hidden-sm" title="{{ __('crud.hints.is_star') }}" data-toggle="tooltip" aria-hidden="true"></i>
            <span class="sr-only">{{ __('pins.learn-more') }}</span>
        </a>
    </label>
    {!! Form::select($fieldName ?? 'is_star', $pinnedOptions, !empty($model) ? $model->is_star : 0, ['class' => 'form-control']) !!}
    <p class="help-block visible-xs visible-sm">{{ __('crud.hints.is_star') }}</p>
</div>
