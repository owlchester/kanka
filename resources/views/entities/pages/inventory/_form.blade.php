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

@if (!isset($inventory))
    <x-helper>{{ __('entities/inventories.create.helper', ['name' => $entity->name]) }}</x-helper>
@endif
<x-grid type="3/3">


    <x-forms.field
        field="name"
        required
        :label="__('entities/inventories.fields.name')">
        <input type="text" name="name" value="{!! htmlspecialchars(old('name', $inventory->name ?? null)) !!}" maxlength="45" class="w-full" placeholder="{{ __('entities/inventories.placeholders.name') }}" data-1p-ignore="true" />
        <x-slot name="helper">{{ __('entities/inventories.helpers.name') }}</x-slot>
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
        required
        :label="__('entities/inventories.fields.amount')"
        :helper="__('entities/inventories.helpers.amount')">

        <input type="number" name="amount" class="w-full" value="{{ old('amount', $inventory->amount ?? 1) }}" min="0" step="1" max="1000000000" required />
    </x-forms.field>

    <x-forms.field
        field="position"
        :label="__('entities/inventories.fields.position')">
        <x-forms.select name="position" :options="$positionOptions" :selected="$positionPreset" class="w-full position-dropdown" :extra="['data-placeholder' => __('entities/inventories.placeholders.position')]" />
    </x-forms.field>


    <x-forms.field field="equipped" :label="__('entities/inventories.fields.is_equipped')">
        <input type="hidden" name="is_equipped" value="0" />
        <x-checkbox :text="__('entities/inventories.helpers.is_equipped')">
            <input type="checkbox" name="is_equipped" value="1" @if (old('is_equipped', $inventory->is_equipped ?? false)) checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>

    <x-forms.field field="copy" :label="__('entities/inventories.fields.copy_entity_entry_v2')">
        <input type="hidden" name="copy_item_entry" value="0" />
        <x-checkbox :text="__('entities/inventories.helpers.copy_entity_entry_v2')">
            <input type="checkbox" name="copy_item_entry" value="1" @if (old('copy_item_entry', $inventory->copy_item_entry ?? false)) checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>

    @include('cruds.fields.visibility_id', ['model' => $inventory ?? null])

    <x-forms.field field="description" css="col-span-3" :label="__('entities/inventories.fields.description')">
        <input type="text" name="description" value="{!! old('description', $inventory->description ?? null) !!}" maxlength="191" class="w-full" placeholder="{{ __('entities/inventories.placeholders.description') }}" />
        <x-slot name="helper">{{ __('entities/inventories.helpers.description') }}</x-slot>
    </x-forms.field>

</x-grid>



