
<div class="form-group">
    {!! Form::select2(
        'family_id',
        (isset($model) && $model->family ? $model->family : $formService->prefillSelect('family', $source)),
        App\Models\Family::class,
        true,
        'families.fields.family'
    ) !!}
</div>

@include('cruds.fields.location')