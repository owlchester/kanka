
<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'quests'])
        @include('cruds.fields.type', ['base' => \App\Models\Quest::class, 'trans' => 'quests'])
        <div class="form-group">
            {!! Form::select2(
                'quest_id',
                (isset($model) && $model->quest ? $model->quest : $formService->prefillSelect('quest', $source, true, \App\Models\Quest::class)),
                App\Models\Quest::class,
                true,
                'quests.fields.quest',
                null,
                'quests.placeholders.quest'
            ) !!}
        </div>
        @include('cruds.fields.character')

        @include('cruds.fields.tags')

        <div class="form-group">
            {!! Form::hidden('is_completed', 0) !!}
            <label>{!! Form::checkbox('is_completed', 1, (!empty($model) ? $model->is_completed : (!empty($source) ? $formService->prefill('is_completed', $source) : 0))) !!}
                {{ trans('quests.fields.is_completed') }}
            </label>
        </div>

        @include('cruds.fields.private')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.entry2')
        @include('cruds.fields.image')
    </div>
</div>