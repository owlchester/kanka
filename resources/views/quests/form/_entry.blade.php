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

    <x-forms.field field="completed" :label="__('quests.fields.is_completed')">
        <select name="is_completed" class="w-full">
            <option value="0" @selected(old('is_completed', $source->child->is_completed ?? $model->is_completed ?? 0) == 0)>{{ __('quests.status.not_started') }}</option>
            <option value="1" @selected(old('is_completed', $source->child->is_completed ?? $model->is_completed ?? 0) == 1)>{{ __('quests.status.ongoing') }}</option>
            <option value="2" @selected(old('is_completed', $source->child->is_completed ?? $model->is_completed ?? 0) == 2)>{{ __('quests.status.completed') }}</option>
            <option value="3" @selected(old('is_completed', $source->child->is_completed ?? $model->is_completed ?? 0) == 3)>{{ __('quests.status.abandoned') }}</option>
        </select>
    </x-forms.field>

    @include('cruds.fields.entry2')

    @include('cruds.fields.tags')
    @include('cruds.fields.image')
</x-grid>
