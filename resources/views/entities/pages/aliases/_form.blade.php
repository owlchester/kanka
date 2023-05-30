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

<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.is_pinned', ['model' => $entity ?? null, 'fieldName' => 'is_pinned'])
    </div>
    <div class="col-md-6">
        @include('cruds.fields.visibility_id', ['model' => $entity ?? null])
    </div>
</div>
<input type="hidden" name="type_id" value="{{ \App\Models\EntityAsset::TYPE_ALIAS }}" />
