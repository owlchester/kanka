

<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'notes'])
    </div>
    <div class="col-md-6">
        @include('cruds.fields.type', ['base' => \App\Models\Note::class, 'trans' => 'notes'])
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::foreignSelect(
                'note_id',
                [
                    'preset' => (isset($model) && $model->note ? $model->note : FormCopy::field('note')->select()),
                    'class' => App\Models\Note::class,
                    'enableNew' => true,
                    'placeholder' => __('notes.placeholders.note'),
                    'labelKey' => 'notes.fields.note',
                    'from' => (isset($model) ? $model : null),
                ]
            ) !!}
        </div>
    </div>
</div>



@include('cruds.fields.entry2')


<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.tags')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.image')
    </div>
</div>

@include('cruds.fields.private2')
