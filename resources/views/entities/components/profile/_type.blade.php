@if (!empty($model->type))
    <div class="element profile-type">
        <div class="title text-uppercase text-xs">{{ __('crud.fields.type') }}</div>
        @php
        $defaultOptions = [$campaign];
        @endphp
        <a href="{{ route($entity->pluralType() . '.index', $defaultOptions + ['_clean' => true, 'type' => $model->type]) }}">{!! $model->type !!}</a>
    </div>
@endif
