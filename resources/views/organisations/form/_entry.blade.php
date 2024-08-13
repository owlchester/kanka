<x-grid>
    @include('cruds.fields.name', ['trans' => 'organisations'])
    @include('cruds.fields.type', ['base' => \App\Models\Organisation::class, 'trans' => 'organisations'])

    @include('cruds.fields.organisation', ['isParent' => true])
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

    <x-forms.field field="defunct" :label="__('organisations.fields.is_defunct')">
        <input type="hidden" name="is_defunct" value="0" />
        <x-checkbox :text="__('organisations.hints.is_defunct')">
            <input type="checkbox" name="is_defunct" value="1" @if (old('is_defunct', $source->is_defunct ?? $model->is_defunct ?? false)) checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>

    @include('cruds.fields.tags')
    @include('cruds.fields.image')
</x-grid>
