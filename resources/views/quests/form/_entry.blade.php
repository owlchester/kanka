
<div class="row">
    <div class="col-md-6">
        <div class="form-group required">
            <label>{{ trans('quests.fields.name') }}</label>
            {!! Form::text('name', $formService->prefill('name', $source), ['placeholder' => trans('quests.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
        @include('cruds.fields.type', ['base' => \App\Models\Quest::class, 'trans' => 'quests'])
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

        @include('cruds.fields.tags')
        @include('cruds.fields.attribute_template')

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