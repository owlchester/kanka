{{ csrf_field() }}

@if (!isset($entityAsset))

    <p class="help-block">
        {{ __('entities/aliases.helpers.primary') }}
    </p>
@endif
<div class="form-group required">
    <label>{{ __('entities/links.fields.name') }}</label>
    {!! Form::text(
        'name',
        null,
        [
            'placeholder' => __('entities/aliases.placeholders.name'),
            'class' => 'form-control',
            'maxlength' => 45
        ]
    ) !!}
</div>

<div class="grid gap-5 grid-cols-1 md:grid-cols-2 mb-4">
    @include('cruds.fields.is_pinned', ['model' => $entity ?? null, 'fieldName' => 'is_pinned'])
    @include('cruds.fields.visibility_id', ['model' => $entity ?? null])
</div>
<input type="hidden" name="type_id" value="{{ \App\Models\EntityAsset::TYPE_ALIAS }}" />
