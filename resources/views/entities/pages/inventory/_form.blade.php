<?php /** @var \App\Models\Inventory $inventory */?>
{{ csrf_field() }}

<x-grid>
    <input type="hidden" name="item_id" value="" />
    @include('cruds.fields.item', [
        'preset' => (!empty($inventory) && $inventory->item ? $inventory->item: false),
        'allowNew' => false,
        'dropdownParent' => request()->ajax() ? '#inventory-dialog' : null,
        'required' => true,
    ])

    <x-forms.field
        field="name"
        :required="true"
        :label="__('entities/inventories.fields.name')">
        {!! Form::text(
            'name',
            null,
            [
                'placeholder' => __('entities/inventories.placeholders.name'),
                'class' => 'form-control',
                'max-length' => 45
            ]
        ) !!}
    </x-forms.field>

    <x-forms.field
        field="amount"
        :required="true"
        :label="__('entities/inventories.fields.amount')">
        {!! Form::number('amount', (empty($inventory) ? 1 : null), ['class' => 'form-control', 'max' => 1000000000, 'min' => 0, 'required']) !!}
    </x-forms.field>

    <x-forms.field
        field="position"
        :label="__('entities/inventories.fields.position')">
        {!! Form::text('position', null, [
            'placeholder' => __('entities/inventories.placeholders.position'),
            'class' => 'form-control',
            'maxlength' => 191,
            'list' => 'position-list',
            'autocomplete' => 'off'
        ]) !!}

        <datalist id="position-list">
            @foreach (\App\Models\Inventory::positionList($campaign)->pluck('position')->all() as $name)
                <option value="{{ e($name) }}">{{ e($name) }}</option>
            @endforeach
        </datalist>
    </x-forms.field>

    <div class="field-description col-span-2">
        <label>{{ __('entities/inventories.fields.description') }}</label>
        {!! Form::text('description', null, ['placeholder' => __('entities/inventories.placeholders.description'), 'class' => 'form-control', 'maxlength' => 191]) !!}
    </div>

    <div class="field-copy">
        <label>
            {!! Form::hidden('copy_item_entry', 0) !!}
            {!! Form::checkbox('copy_item_entry') !!}
            {{ __('entities/inventories.fields.copy_entity_entry') }}
            <x-helpers.tooltip :title="__('entities/inventories.helpers.copy_entity_entry')" />
        </label>
        <p class="help-block md:hidden m-0">
            {{ __('entities/inventories.helpers.copy_entity_entry') }}
        </p>
    </div>
    <div class="field-equipped">
        {!! Form::hidden('is_equipped', 0) !!}
        <label>
            {!! Form::checkbox('is_equipped', 1, isset($inventory) ? $inventory->is_equipped : null) !!}
            {{ __('entities/inventories.fields.is_equipped') }}
        </label>
    </div>

    @include('cruds.fields.visibility_id', ['model' => $inventory ?? null])
</x-grid>



