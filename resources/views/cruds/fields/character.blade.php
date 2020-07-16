@if ($campaign->enabled('characters'))
    <div class="form-group">
        {!! Form::select2(
            'character_id',
            (isset($model) && $model->character ? $model->character : FormCopy::field('character')->select()),
            App\Models\Character::class,
            isset($enableNew) ? $enableNew : true,
            isset($label) ? $label : null
        ) !!}
    </div>
@endif
