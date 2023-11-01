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

    @include('cruds.fields.tags')

    @include('cruds.fields.image')
</x-grid>

