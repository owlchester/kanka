<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'events'])

    </div>
    <div class="col-md-6">
        @include('cruds.fields.type', ['base' => \App\Models\Event::class, 'trans' => 'events'])
    </div>
</div>


@include('cruds.fields.entry2')

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ trans('events.fields.date') }}</label>
            {!! Form::text('date', FormCopy::field('date')->string(), ['placeholder' => trans('events.placeholders.date'), 'class' => 'form-control', 'maxlength' => 191]) !!}
            <p class="help-block">{{ __('events.helpers.date') }}</p>
        </div>

        @include('cruds.fields.location')

        @include('cruds.fields.tags')

        @include('cruds.fields.private')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.image')
    </div>
</div>
