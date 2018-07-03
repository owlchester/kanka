@if ($campaign->enabled('sections'))
    <div class="form-group">
        {!! Form::select2(
            'section_id',
            (isset($model) && $model->section ? $model->section : $formService->prefillSelect('section', $source)),
            App\Models\Section::class,
            true
        ) !!}
    </div>
@endif