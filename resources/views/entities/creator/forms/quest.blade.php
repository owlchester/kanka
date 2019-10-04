@include('cruds.fields.type', ['base' => \App\Models\Quest::class, 'trans' => 'quests'])
<div class="form-group">
    {!! Form::select2(
        'quest_id',
        (isset($model) && $model->quest ? $model->quest : FormCopy::field('quest')->select()),
        App\Models\Quest::class,
        true,
        'quests.fields.quest',
        null,
        'quests.placeholders.quest'
    ) !!}
</div>
@include('cruds.fields.character')