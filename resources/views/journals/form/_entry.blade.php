
<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'journals'])
    </div>
    <div class="col-md-6">
        @include('cruds.fields.type', ['base' => \App\Models\Journal::class, 'trans' => 'journals'])
    </div>
</div>

@include('cruds.fields.entry2')


<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.character', ['label' => 'journals.fields.author'])
        @include('cruds.fields.location')

        @include('cruds.fields.tags')

        <div class="form-group">
            <label>{{ trans('journals.fields.date') }}</label>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                {!! Form::text('date', FormCopy::field('date')->string(), ['placeholder' => trans('journals.placeholders.date'), 'id' => 'date', 'class' => 'form-control date-picker']) !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::foreignSelect(
                'journal_id',
                [
                'preset' => (isset($model) && $model->journal ? $model->journal : FormCopy::field('journal')->select()),
                'class' => App\Models\Journal::class,
                'enableNew' => true,
                'labelKey' => __('journals.fields.journal'),
                'placeholderKey' => 'journals.placeholders.journal',
                'from' => (isset($model) ? $model : null),
            ]
            ) !!}
        </div>

        @include('cruds.fields.image')
    </div>
</div>

@include('cruds.fields.private2')
