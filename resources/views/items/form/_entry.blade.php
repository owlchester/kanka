<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'items'])
    </div>
    <div class="col-md-6">
        @include('cruds.fields.type', ['base' => \App\Models\Item::class, 'trans' => 'items'])
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.price', ['trans' => 'items'])
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('items.fields.size') }}</label>
            {!! Form::text('size', FormCopy::field('size')->string(), ['placeholder' => __('items.placeholders.size'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.location', ['quickCreator' => true])
    </div>
    <div class="col-md-6">
        @include('cruds.fields.character', ['quickCreator' => true])
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
