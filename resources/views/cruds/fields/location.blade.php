@if ($campaign->enabled('locations'))
    <div class="form-group">
        {!! Form::select2(
            'location_id',
            (isset($model) && $model->location ? $model->location : $formService->prefillSelect('location', $source)),
            App\Models\Location::class,
            true
        ) !!}
    </div>
@endif