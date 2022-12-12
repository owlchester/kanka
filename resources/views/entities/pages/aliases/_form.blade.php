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

@include('cruds.fields.visibility_id', ['model' => $entity ?? null])

<input type="hidden" name="type_id" value="{{ \App\Models\EntityAsset::TYPE_ALIAS }}" />
