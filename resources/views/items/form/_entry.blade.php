<x-grid>
    @include('cruds.fields.name', ['trans' => 'items'])
    @include('cruds.fields.type', ['base' => \App\Models\Item::class, 'trans' => 'items'])

    @include('cruds.fields.item', ['isParent' => true])
    @include('cruds.fields.price', ['trans' => 'items'])

    <div class="field-size">
        <label>{{ __('items.fields.size') }}</label>
        {!! Form::text('size', FormCopy::field('size')->string(), ['placeholder' => __('items.placeholders.size'), 'class' => 'form-control', 'maxlength' => 191]) !!}
    </div>

    @include('cruds.fields.location')

    @include('cruds.fields.character', ['label' => __('items.fields.character'), 'name' => 'character_id'])

    @include('cruds.fields.entry2')

    @include('cruds.fields.tags')
    @include('cruds.fields.image')
</x-grid>
