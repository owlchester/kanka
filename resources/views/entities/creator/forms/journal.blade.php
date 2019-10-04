@include('cruds.fields.type', ['base' => \App\Models\Journal::class, 'trans' => 'journals'])

@if ($campaign->enabled('characters'))
    <div class="form-group">
        {!! Form::select2(
            'character_id',
            (isset($model) && $model->character ? $model->character : FormCopy::field('character')->select()),
            App\Models\Character::class,
            false,
            'journals.fields.author'
        ) !!}
    </div>
@endif