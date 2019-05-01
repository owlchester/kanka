
<div class="row">
    <div class="col-md-6">
        <div class="form-group required">
            <label>{{ trans('notes.fields.name') }}</label>
            {!! Form::text('name', $formService->prefill('name', $source), ['placeholder' => trans('notes.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
        @include('cruds.fields.type', ['base' => \App\Models\Note::class, 'trans' => 'notes'])
        @include('cruds.fields.tags')
        @include('cruds.fields.attribute_template')

        @include('cruds.fields.private')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.entry2')
        @include('cruds.fields.image')
    </div>
</div>