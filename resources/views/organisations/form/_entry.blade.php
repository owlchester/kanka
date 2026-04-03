<x-grid>
    @include('cruds.fields.entity-name')
    @include('cruds.fields.type', ['base' => \App\Models\Organisation::class, 'trans' => 'organisations'])

    @include('cruds.fields.parent')
    @include('cruds.fields.locations', ['from' => $model ?? null, 'quickCreator' => true])

    @include('cruds.fields.entry2')

@if ($campaign->enabled('characters'))
    <x-forms.field field="member">
        <input type="hidden" name="sync_org_members" value="1">
        @include('components.form.members', ['options' => [
            'model' => $model ?? FormCopy::model(),
            'source' => $source ?? null
        ]])
    </x-forms.field>
@endif

    @include('cruds.fields.status')

    @include('cruds.fields.tags')
    @include('cruds.fields.image')
</x-grid>
