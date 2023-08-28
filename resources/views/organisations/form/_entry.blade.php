<x-grid>
    @include('cruds.fields.name', ['trans' => 'organisations'])
    @include('cruds.fields.type', ['base' => \App\Models\Organisation::class, 'trans' => 'organisations'])

    @include('cruds.fields.organisation', ['isParent' => true])
    @include('cruds.fields.location')

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
        {!! Form::hidden('is_defunct', 0) !!}
        <label class="text-neutral-content cursor-pointer flex gap-2">
            {!! Form::checkbox('is_defunct', 1, $model->is_defunct ?? '' )!!}
            <span>{{ __('organisations.hints.is_defunct') }}</span>
        </label>
    </x-forms.field>

    @include('cruds.fields.tags')
    @include('cruds.fields.image')
</x-grid>
