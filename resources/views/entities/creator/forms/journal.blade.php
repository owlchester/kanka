<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.type', ['base' => \App\Models\Journal::class, 'trans' => 'journals'])
    </div>
    <div class="col-md-6">
        @if ($campaignService->enabled('characters'))
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
    </div>
</div>
