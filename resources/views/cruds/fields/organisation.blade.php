@if ($campaign->enabled('organisations'))
    <div class="form-group">
        {!! Form::select2(
            'organisation_id',
            (isset($model) && $model->organisation ? $model->organisation : $formService->prefillSelect('organisation', $source)),
            App\Models\Organisation::class,
            true
        ) !!}
    </div>
@endif