{{ csrf_field() }}

@if (!isset($entityAsset))

    <p class="help-block">
        {{ __('entities/aliases.helpers.primary') }}
    </p>
@endif

<x-grid>
    <div class="col-span-2 field-name required">
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

    @include('cruds.fields.is_pinned', ['model' => $entity ?? null, 'fieldName' => 'is_pinned'])
    @include('cruds.fields.visibility_id', ['model' => $entity ?? null])
</x-grid>
<input type="hidden" name="type_id" value="{{ \App\Models\EntityAsset::TYPE_ALIAS }}" />
