<div class="row">
    <div class="col-md-6">
        <div class="form-group required">
            <label>{{ trans('items.fields.name') }}</label>
            {!! Form::text('name', $formService->prefill('name', $source), ['placeholder' => trans('items.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
        @include('cruds.fields.type', ['base' => \App\Models\Item::class, 'trans' => 'items'])

        <div class="form-group">
            <label>{{ trans('items.fields.price') }}</label>
            {!! Form::text('price', $formService->prefill('price', $source), ['placeholder' => trans('items.placeholders.price'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('items.fields.size') }}</label>
            {!! Form::text('size', $formService->prefill('size', $source), ['placeholder' => trans('items.placeholders.size'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
        @include('cruds.fields.location')
        @include('cruds.fields.character')

        @include('cruds.fields.tags')
        @include('cruds.fields.attribute_template')

        @include('cruds.fields.private')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.entry2')
        @include('cruds.fields.image')
    </div>
</div>