<x-grid type="1/1">
    <x-forms.field field="name" :label="__('campaigns/gallery.fields.name')">
        {!! Form::text('name', null, ['class' => 'w-full', 'maxlength' => 100, 'required']) !!}
    </x-forms.field>

    @include('cruds.fields.visibility_id', ['model' => null])
</x-grid>
