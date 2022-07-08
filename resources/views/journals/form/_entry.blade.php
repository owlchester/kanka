<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'journals'])
    </div>
    <div class="col-md-6">
        @include('cruds.fields.type', ['base' => \App\Models\Journal::class, 'trans' => 'journals'])
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::foreignSelect(
                'journal_id',
                [
                    'preset' => (isset($model) && $model->journal ? $model->journal : FormCopy::field('journal')->select(true, \App\Models\Journal::class)),
                    'class' => App\Models\Journal::class,
                    'enableNew' => true,
                    'labelKey' => __('journals.fields.journal'),
                    'placeholderKey' => 'journals.placeholders.journal',
                    'from' => (isset($model) ? $model : null),
                    'quickCreator' => true,
                ]
            ) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('journals.fields.date') }}</label>
            {!! Form::date('date', FormCopy::field('date')->string(), ['class' => 'form-control']) !!}
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-sm-6">
                @include('cruds.fields.author')
            </div>
            <div class="col-sm-6">
                @include('cruds.fields.location', ['quickCreator' => true])
            </div>
        </div>

    </div>
    <div class="col-md-6">
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

<hr />
@include('cruds.forms._calendar', ['source' => $source])


@includeWhen(auth()->user()->isAdmin(), 'cruds.fields.privacy_callout')
