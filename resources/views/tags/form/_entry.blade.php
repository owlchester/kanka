<x-grid>
    @include('cruds.fields.name', ['trans' => 'tags'])
    @include('cruds.fields.type', ['base' => \App\Models\Tag::class, 'trans' => 'tags'])

    @include('cruds.fields.tag', ['isParent' => true])
    @include('cruds.fields.colour')

    @include('cruds.fields.entry2')

    <x-forms.field field="auto-apply" :label="__('tags.fields.is_auto_applied')">
        {!! Form::hidden('is_auto_applied', 0) !!}
        <label class="text-neutral-content cursor-pointer">
            {!! Form::checkbox('is_auto_applied', 1, $model->is_auto_applied ?? '' )!!}
            {{ __('tags.hints.is_auto_applied') }}
        </label>
    </x-forms.field>
    <x-forms.field field="hidden" :label="__('tags.fields.is_hidden')">
        {!! Form::hidden('is_hidden', 0) !!}
        <label class="text-neutral-content cursor-pointer">
            {!! Form::checkbox('is_hidden', 1, $model->is_hidden ?? '' )!!}
            {{ __('tags.hints.is_hidden') }}
        </label>
    </x-forms.field>
    @include('cruds.fields.image')

</x-grid>
