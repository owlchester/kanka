<x-grid>
    @include('cruds.fields.name', ['trans' => 'quests'])
    @include('cruds.fields.type', ['base' => \App\Models\Quest::class, 'trans' => 'quests'])

    @include('cruds.fields.quest', ['isParent' => true])
    @include('cruds.fields.instigator')
    @include('cruds.fields.location')

    @include('cruds.fields.date')
    <x-forms.field field="completed" :label="__('quests.fields.is_completed')">
        <input type="hidden" name="is_completed" value="0" />
        <x-checkbox :text="__('quests.helpers.is_completed')">
            <input type="checkbox" name="is_completed" value="1" @if ($source->is_completed ?? old('is_completed', $model->is_completed ?? false)) checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>

    @include('cruds.fields.entry2')

    @include('cruds.fields.tags')
    @include('cruds.fields.image')
</x-grid>

<hr />
@include('cruds.forms._calendar', ['source' => $source])
