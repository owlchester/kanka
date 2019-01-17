@if ($campaign->enabled('families'))
    <div class="form-group">
        {!! Form::select2(
            'family_id',
            (isset($model) && $model->family ? $model->family : $formService->prefillSelect('family', $source)),
            App\Models\Family::class,
            isset($enableNew) ? $enableNew : true
        ) !!}
    </div>
@endif