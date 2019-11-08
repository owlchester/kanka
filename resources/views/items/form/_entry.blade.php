<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'items'])
        @include('cruds.fields.type', ['base' => \App\Models\Item::class, 'trans' => 'items'])
        @include('cruds.fields.price', ['trans' => 'items'])
        <div class="form-group">
            <label>{{ trans('items.fields.size') }}</label>
            {!! Form::text('size', FormCopy::field('size')->string(), ['placeholder' => trans('items.placeholders.size'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
        @include('cruds.fields.location')
        @include('cruds.fields.character')

        @include('cruds.fields.tags')

        @include('cruds.fields.private')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.entry2')
        @include('cruds.fields.image')
    </div>
</div>