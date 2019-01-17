<div class="form-group">
    <label>{{ trans('quests.fields.type') }}</label>
    {!! Form::text('type', $formService->prefill('type', $source), ['placeholder' => trans('quests.placeholders.type'), 'class' => 'form-control', 'maxlength' => 191]) !!}
</div>
<div class="form-group">
    {!! Form::select2(
        'quest_id',
        (isset($model) && $model->quest ? $model->quest : $formService->prefillSelect('quest', $source)),
        App\Models\Quest::class,
        true,
        'quests.fields.quest',
        null,
        'quests.placeholders.quest'
    ) !!}
</div>
@include('cruds.fields.character')