<?php /** @var \App\Models\Inventory $inventory */?>
{{ csrf_field() }}
@php
$preset = null;

if (isset($inventory) && $inventory->image_uuid) {
    $preset = $inventory->image;
}
if (isset($inventory)) {
    $positionPreset = $inventory->position;
}
@endphp
<x-grid type="3/3">


    <x-forms.field
        field="name"
        :required="true"
        :helper="__('entities/inventories.helpers.name')"
        :label="__('entities/inventories.fields.name')">
        {!! Form::text(
            'name',
            null,
            [
                'placeholder' => __('entities/inventories.placeholders.name'),
                'class' => '',
                'max-length' => 45
            ]
        ) !!}
    </x-forms.field>

    <input type="hidden" name="item_id" value="" />
    @include('cruds.fields.item', [
        'preset' => (!empty($inventory) && $inventory->item ? $inventory->item: false),
        'allowNew' => false,
        'dropdownParent' => request()->ajax() ? '#primary-dialog' : null,
        'required' => true,
        'multiple' => isset($multiple),
    ])

    <x-forms.field
        css="row-span-2"
        field="image-uuid"
        :label="__('crud.fields.image')">

                <x-forms.foreign
                    field="image-uuid"
                    :campaign="$campaign"
                    name="image_uuid"
                    :allowClear="true"
                    :route="route('images.find', $campaign)"
                    :placeholder="__('fields.gallery.placeholder')"
                    :selected="$preset">
                </x-forms.foreign>

            @if (!empty($inventory) && !empty($inventory->image_uuid) && !empty($inventory->image))
                <div class="preview w-32">
                    @include('cruds.fields._image_preview', [
                        'image' => $inventory->image->getUrl(192, 144),
                        'title' => $inventory->name,
                    ])
                </div>
            @endif
    </x-forms.field>

    <x-forms.field
        field="amount"
        :required="true"
        :label="__('entities/inventories.fields.amount')"
        :helper="__('entities/inventories.helpers.amount')">
        {!! Form::number('amount', (empty($inventory) ? 1 : null), ['class' => '', 'max' => 1000000000, 'min' => 0, 'required']) !!}
    </x-forms.field>

    <x-forms.field
        field="position"
        :label="__('entities/inventories.fields.position')">
        {!! Form::select('position', $positionOptions, $positionPreset, [
            'data-placeholder' => __('entities/inventories.placeholders.position'),
            'class' => 'position-dropdown',
        ]) !!}
    </x-forms.field>


    <x-forms.field field="equipped" :label="__('entities/inventories.fields.is_equipped')">
        {!! Form::hidden('is_equipped', 0) !!}
        <x-checkbox :text="__('entities/inventories.helpers.is_equipped')">
            {!! Form::checkbox('is_equipped', 1, isset($inventory) ? $inventory->is_equipped : null) !!}
        </x-checkbox>
    </x-forms.field>

    <x-forms.field field="copy" :label="__('entities/inventories.fields.copy_entity_entry_v2')">
        {!! Form::hidden('copy_item_entry', 0) !!}
        <x-checkbox :text="__('entities/inventories.helpers.copy_entity_entry_v2')">
            {!! Form::checkbox('copy_item_entry') !!}
        </x-checkbox>
    </x-forms.field>

    @include('cruds.fields.visibility_id', ['model' => $inventory ?? null])

    <x-forms.field field="description" css="col-span-3" :label="__('entities/inventories.fields.description')" :helper="__('entities/inventories.helpers.description')">
        {!! Form::text('description', null, ['placeholder' => __('entities/inventories.placeholders.description'), 'class' => '', 'maxlength' => 191]) !!}
    </x-forms.field>

</x-grid>



