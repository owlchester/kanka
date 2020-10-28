
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

        @include('cruds.fields.private')
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::select2(
                'journal_id',
                (isset($model) && $model->journal ? $model->journal : FormCopy::field('journal')->select()),
                App\Models\Journal::class,
                true,
                __('journals.fields.journal'),
                null,
                __('journals.placeholders.journal')
            ) !!}
        </div>

        @include('cruds.fields.image')
    </div>
</div>
