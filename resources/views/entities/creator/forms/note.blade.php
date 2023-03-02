<div class="row">
    <div class="col-sm-6">
        @include('cruds.fields.type', ['base' => \App\Models\Note::class, 'trans' => 'notes'])
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::select2(
                'note_id',
                (isset($model) && $model->note ? $model->note : FormCopy::field('note')->select()),
                App\Models\Note::class,
                false,
                'notes.fields.note',
                'notes.find',
                'notes.placeholders.note',
                null,
                request()->ajax() ? '#entity-modal' : null,
            ) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <label>{{ __('crud.fields.entry') }}</label>
    {!! Form::textarea('entry', FormCopy::field('entry')->string(), ['class' => 'form-control resize-y', 'rows' => 5]) !!}
</div>
