@if (!empty($model->type))
    <div class="element profile-type">
        <div class="title text-uppercase text-xs">{{ __('crud.fields.type') }}</div>
        {!! $model->entity->typeLink() !!}
    </div>
@endif
