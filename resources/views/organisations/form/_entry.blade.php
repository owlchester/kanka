<x-grid>
    @include('cruds.fields.name', ['trans' => 'organisations'])
    @include('cruds.fields.type', ['base' => \App\Models\Organisation::class, 'trans' => 'organisations'])

    @include('cruds.fields.organisation', ['isParent' => true])
    @include('cruds.fields.location')

    @include('cruds.fields.entry2')

@if ($campaign->enabled('characters'))
    <div class="field-members">
        <input type="hidden" name="sync_org_members" value="1">
        @include('components.form.members', ['options' => [
            'model' => $model ?? FormCopy::model(),
            'source' => $source ?? null
        ]])
    </div>
@endif

    <div class="field-defunct">
        {!! Form::hidden('is_defunct', 0) !!}
        <label>{!! Form::checkbox('is_defunct', 1, $model->is_defunct ?? '' )!!}
            {{ __('organisations.fields.is_defunct') }}
        </label>
        <p class="help-block">{{ __('organisations.hints.is_defunct') }}</p>
    </div>

    @include('cruds.fields.tags')
    @include('cruds.fields.image')
</x-grid>
