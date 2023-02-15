<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.type', ['base' => \App\Models\Journal::class, 'trans' => 'journals'])
    </div>
    <div class="col-md-6">
        @if ($campaign->enabled('characters'))
            <div class="form-group">
                {!! Form::select2(
                    'character_id',
                    (isset($model) && $model->character ? $model->character : FormCopy::field('character')->select()),
                    App\Models\Character::class,
                    false,
                    'journals.fields.author',
                    null,
                    null,
                    null,
                    request()->ajax() ? '#entity-modal' : null,
                ) !!}
            </div>
        @endif
    </div>
</div>
