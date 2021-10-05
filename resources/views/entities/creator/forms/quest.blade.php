@include('cruds.fields.type', ['base' => \App\Models\Quest::class, 'trans' => 'quests'])

<div class="row">

    <div class="col-lg-6">
        <div class="form-group">
            {!! Form::select2(
                'quest_id',
                (isset($model) && $model->quest ? $model->quest : FormCopy::field('quest')->select()),
                App\Models\Quest::class,
                false,
                'quests.fields.quest',
                null,
                'quests.placeholders.quest'
            ) !!}
        </div>
    </div>
    <div class="col-lg-6">
        @include('cruds.fields.character')
    </div>
</div>
