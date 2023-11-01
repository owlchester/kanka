<x-forms.field field="instigator">
    <input type="hidden" name="instigator_id" value="" />
        @include('cruds.fields.entity', [
        'name' => 'instigator_id',
        'preset' => !empty($model) && $model->instigator ? $model->instigator : null,
        'relation' => 'instigator',
        'label' => __('quests.fields.instigator'),
    ])
</x-forms.field>
