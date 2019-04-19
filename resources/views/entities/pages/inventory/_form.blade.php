{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            {!! Form::select2(
                'item_id',
                (!empty($inventory) && $inventory->item ? $inventory->item: null),
                App\Models\Item::class,
                false,
                'crud.fields.item',
                'items.find',
                'crud.placeholders.item'
            ) !!}
        </div>

        <div class="form-group required">
            <label>{{ trans('entities/inventories.fields.amount') }}</label>
            {!! Form::text('amount', null, ['placeholder' => trans('entities/inventories.placeholders.amount'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>

        <div class="form-group required">
            <label>{{ trans('entities/inventories.fields.position') }}</label>
            {!! Form::text('position', null, [
                'placeholder' => trans('entities/inventories.placeholders.position'),
                'class' => 'form-control',
                'maxlength' => 191,
                'list' => 'position-list',
                'autocomplete' => 'off'
            ]) !!}
        </div>
        <div class="hidden">
            <datalist id="position-list">
                @foreach (\App\Models\Inventory::positionList() as $name)
                    <option value="{{ $name }}">{{ $name }}</option>
                @endforeach
            </datalist>
        </div>

        <div class="row">
            <div class="col-md-12">
                @include('cruds.fields.visibility')
            </div>
        </div>
    </div>
</div>