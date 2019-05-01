<div class="row">
    <div class="col-md-6">
        <div class="form-group required">
            <label>{{ trans('events.fields.name') }}</label>
            {!! Form::text('name', $formService->prefill('name', $source), ['placeholder' => trans('events.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
        @include('cruds.fields.type', ['base' => \App\Models\Event::class, 'trans' => 'events'])
        <div class="form-group">
            <label>{{ trans('events.fields.date') }}</label>
            {!! Form::text('date', $formService->prefill('date', $source), ['placeholder' => trans('events.placeholders.date'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
        @include('cruds.fields.location')

        @include('cruds.fields.tags')
        @include('cruds.fields.attribute_template')

        @include('cruds.fields.private')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.entry2')
        @include('cruds.fields.image')
    </div>
</div>