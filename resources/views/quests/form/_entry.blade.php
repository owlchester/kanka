<x-grid>
    @include('cruds.fields.name', ['trans' => 'quests'])
    @include('cruds.fields.type', ['base' => \App\Models\Quest::class, 'trans' => 'quests'])

    @include('cruds.fields.quest', ['isParent' => true])
    @include('cruds.fields.instigator')

    @include('cruds.fields.date')
    <x-forms.field field="completed" :label="__('quests.fields.is_completed')">
        <input type="hidden" name="is_completed" value="0" />
        <x-checkbox :text="__('quests.helpers.is_completed')">
            {!! Form::checkbox('is_completed', 1, (!empty($model) ? $model->is_completed : (!empty($source) ? FormCopy::field('is_completed')->boolean() : 0))) !!}
        </x-checkbox>
    </x-forms.field>

    @include('cruds.fields.entry2')

    @include('cruds.fields.tags')
    @include('cruds.fields.image')
</x-grid>

<hr />
@include('cruds.forms._calendar', ['source' => $source])
