{{ csrf_field() }}
<x-grid>
    <x-forms.field
        field="name"
        :label="__('entities/links.fields.name')"
        :required="true">
        {!! Form::text(
            'name',
            null,
            [
                'placeholder' => __('entities/links.placeholders.name'),
                'class' => '',
                'maxlength' => 45
            ]
        ) !!}
    </x-forms.field>

    <x-forms.field
        field="url"
        :label="__('entities/links.fields.url')"
        :required="true">
        {!! Form::text(
            'metadata[url]',
            null,
            [
                'placeholder' => __('entities/links.placeholders.url'),
                'class' => '',
                'maxlength' => 255
            ]
        ) !!}
    </x-forms.field>

    @include('cruds.fields.icon', ['iconFieldName' => 'metadata[icon]', 'placeholder' => 'fa-brands fa-d-and-d-beyond, ra ra-aura'])
    @include('cruds.fields.visibility_id', ['model' => $entity ?? null])
</x-grid>
<input type="hidden" name="type_id" value="{{ \App\Models\EntityAsset::TYPE_LINK }}" />
