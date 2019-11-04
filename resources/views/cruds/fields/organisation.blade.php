@if ($campaign->enabled('organisations'))
    <div class="form-group">
        {!! Form::select2(
            'organisation_id',
            (isset($model) && $model->organisation ? $model->organisation : FormCopy::field('organisation')->select()),
            App\Models\Organisation::class,
            isset($enableNew) ? $enableNew : true
        ) !!}
    </div>
@endif