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
        @include('cruds.fields.journal', ['isParent' => true])
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
                @include('cruds.fields.location')
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

