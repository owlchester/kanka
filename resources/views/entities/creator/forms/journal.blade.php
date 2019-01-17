<div class="form-group">
    <label>{{ trans('journals.fields.type') }}</label>
    {!! Form::text('type', $formService->prefill('type', $source), ['placeholder' => trans('journals.placeholders.type'), 'class' => 'form-control', 'maxlength' => 191]) !!}
</div>
@if ($campaign->enabled('characters'))
    <div class="form-group">
        {!! Form::select2(
            'character_id',
            (isset($model) && $model->character ? $model->character : $formService->prefillSelect('character', $source)),
            App\Models\Character::class,
            false,
            'journals.fields.author'
        ) !!}
    </div>
@endif