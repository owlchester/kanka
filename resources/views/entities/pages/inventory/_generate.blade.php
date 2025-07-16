<?php /** @var \App\Models\Inventory $inventory */?>
<x-grid type="1/1">
    <x-helper>
        <p>{{ __('entities/inventories.generate.helper', ['name' => $entity->name]) }}</p>
    </x-helper>

    <x-forms.field
        field="item_amount"
        :label="__('entities/inventories.fields.item_amount')">
        <input type="number" name="item_amount" class="w-full" placeholder="{{ __('entities/inventories.fields.item_amount') }}" aria-label="{{ __('entities/inventories.fields.item_amount') }}" />
    </x-forms.field>

    <x-grid type="2/2">
        @include('cruds.fields.tags')

        <x-forms.field field="match_all" :label="__('entities/inventories.fields.match_all')">
            <select name="match_all" class="w-full">
                <option value="0">{{ __('general.no') }}</option>
                <option value="1">{{ __('general.yes') }}</option>
            </select>
        </x-forms.field>
    </x-grid>

    <x-forms.field field="replace" css="col-span-2" :label="__('entities/inventories.fields.replace')">
        <input type="hidden" name="replace" value="0" />
        <x-checkbox :text="__('entities/inventories.helpers.replace')">
            <input type="checkbox" name="replace" value="1" />
        </x-checkbox>
    </x-forms.field>
</x-grid>
