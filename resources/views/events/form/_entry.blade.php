<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'events'])
    </div>
    <div class="col-md-6">
        @include('cruds.fields.type', ['base' => \App\Models\Event::class, 'trans' => 'events'])
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.event', ['parent' => true, 'from' => isset($model) ? $model : null, 'quickCreator' => true])

        @include('cruds.fields.location', ['quickCreator' => true])
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('events.fields.date') }}</label>
            {!! Form::text('date', FormCopy::field('date')->string(), ['placeholder' => __('events.placeholders.date'), 'class' => 'form-control', 'maxlength' => 191]) !!}
            <p class="help-block">{{ __('events.helpers.date') }}</p>
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
