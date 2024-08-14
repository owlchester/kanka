<x-grid>
    @include('cruds.fields.name', ['trans' => 'families'])

    @include('cruds.fields.type', ['base' => \App\Models\Family::class, 'trans' => 'families'])

    @include('cruds.fields.family', ['isParent' => true])

    @include('cruds.fields.location')

    @include('cruds.fields.entry2')

    @if ($campaign->enabled('characters'))
        <x-forms.field field="members">
            <input type="hidden" name="sync_family_members" value="1">
            @include('components.form.family_members', ['options' => [
                'model' => $model ?? FormCopy::model(),
                'source' => $source ?? null,
            ]])
        </x-forms.field>
    @endif

    <x-forms.field field="extinct" :label="__('creatures.fields.is_extinct')">
        <input type="hidden" name="is_extinct" value="0" />
        <x-checkbox :text="__('families.hints.is_extinct')">
            <input type="checkbox" name="is_extinct" value="1" @if (old('is_extinct', $source->is_extinct ?? $model->is_extinct ?? false)) checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>

    @include('cruds.fields.tags')

    @include('cruds.fields.image')
</x-grid>

