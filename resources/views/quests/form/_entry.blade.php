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
        <input type="hidden" name="is_completed" value="0" />
        <x-checkbox :text="__('quests.helpers.is_completed')">
            <input type="checkbox" name="is_completed" value="1" @if (old('is_completed', $source->child->is_completed ?? $model->is_completed ?? false)) checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>

    @include('cruds.fields.entry2')

    @include('cruds.fields.tags')
    @include('cruds.fields.image')
</x-grid>
