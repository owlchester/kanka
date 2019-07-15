<div class="row">
    <div class="col-md-6">
        <div class="form-group required">
            <label>{{ trans('tags.fields.name') }}</label>
            {!! Form::text('name', $formService->prefill('name', $source), ['placeholder' => trans('tags.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
        @include('cruds.fields.type', ['base' => \App\Models\Tag::class, 'trans' => 'tags'])

        <div class="form-group">
            <label>{{ trans('calendars.fields.colour') }}</label>
            {!! Form::select('colour', $formService->colours(), $formService->prefill('colour', $source), ['class' => 'form-control']) !!}
        </div>
        @include('cruds.fields.tag', ['parent' => true])
@include('cruds.fields.private')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.entry2')
        @include('cruds.fields.image')
    </div>
</div>
