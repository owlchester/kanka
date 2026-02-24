<x-grid>
    @include('cruds.fields.entity-name')
    @include('cruds.fields.type', ['base' => \App\Models\Tag::class, 'trans' => 'tags'])

    @include('cruds.fields.tag', ['isParent' => true])
    @include('cruds.fields.colour')

    @include('cruds.fields.entry2')

    <x-forms.field field="auto-apply" :label="__('tags.fields.is_auto_applied')">
        <input type="hidden" name="is_auto_applied" value="0" />
        <x-checkbox :text="__('tags.hints.is_auto_applied')">
            <input type="checkbox" name="is_auto_applied" value="1" @if (old('is_auto_applied', $source->child->is_auto_applied ?? $model->is_auto_applied ?? false)) checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>
    <x-forms.field field="hidden" :label="__('tags.fields.is_hidden')">
        <input type="hidden" name="is_hidden" value="0" />
        <x-checkbox :text="__('tags.hints.is_hidden')">
            <input type="checkbox" name="is_hidden" value="1" @if (old('is_hidden', $source->child->is_hidden ?? $model->is_hidden ?? false)) checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>

    @include('cruds.fields.tags')
    @include('cruds.fields.image')

</x-grid>
