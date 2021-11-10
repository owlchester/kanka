@if (!empty($model->type))
    <div class="element profile-type">
        <div class="title">{{ __('crud.fields.type') }}</div>
        {{ $model->type }}
    </div>
@endif
