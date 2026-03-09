<x-grid>
    @include('cruds.fields.entity-name')
    @include('cruds.fields.type', ['base' => \App\Models\Quest::class, 'trans' => 'quests'])

    @include('cruds.fields.quest', ['isParent' => true])
    @include('cruds.fields.instigator')
    @include('cruds.fields.location')

    @include('cruds.fields.date')

    <div class="col-span-2">
        @include('cruds.forms._calendar', ['source' => $source])
    </div>

    <x-forms.field field="status_id" :label="__('quests.fields.status')">
        <select name="status_id" class="w-full">
            <option value="0" @selected(old('status_id', $source->child->status_id?->value ?? $model->status_id?->value ?? 0) == 0)>{{ __('quests.status.not_started') }}</option>
            <option value="1" @selected(old('status_id', $source->child->status_id?->value ?? $model->status_id?->value ?? 0) == 1)>{{ __('quests.status.ongoing') }}</option>
            <option value="2" @selected(old('status_id', $source->child->status_id?->value ?? $model->status_id?->value ?? 0) == 2)>{{ __('quests.status.completed') }}</option>
            <option value="3" @selected(old('status_id', $source->child->status_id?->value ?? $model->status_id?->value ?? 0) == 3)>{{ __('quests.status.abandoned') }}</option>
        </select>
    </x-forms.field>

    @include('cruds.fields.entry2')

    @include('cruds.fields.tags')
    @include('cruds.fields.image')
</x-grid>
