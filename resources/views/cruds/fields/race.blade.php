@if ($campaign->enabled('races'))
    <div class="form-group">
        {!! Form::select2(
            'race_id',
            (isset($model) && $model->face ? $model->race : $formService->prefillSelect('race', $source)),
            App\Models\Race::class,
            true
        ) !!}
    </div>
@endif