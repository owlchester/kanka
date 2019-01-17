@if ($campaign->enabled('characters'))
    <div class="form-group">
        {!! Form::select2(
            'character_id',
            (isset($model) && $model->character ? $model->character : $formService->prefillSelect('character', $source)),
            App\Models\Character::class,
            isset($enableNew) ? $enableNew : true
        ) !!}
    </div>
@endif