@inject('typeService', 'App\Services\Entity\TypeService')
@php
$entityTypes = ['' => '', 'any' => __('bookmarks.random_types.any')];
$entityTypes = $typeService->campaign($campaign)->plural()->permissionless()->exclude(['bookmark'])->singularKey()->add($entityTypes)->get();
@endphp


<x-grid type="1/1">
    <x-helper :text="__('bookmarks.helpers.random')" />

    <x-grid>
        <x-forms.field field="random-type" :label="__('bookmarks.fields.random_type')">
            <x-forms.select name="random_entity_type" :options="$entityTypes" :selected="$source->random_entity_type ?? $model->random_entity_type ?? null" />
        </x-forms.field>

        <div>
            <input type="hidden" name="save_tags" value="1" />
            <x-forms.tags
                :campaign="$campaign"
                :model="$model ?? null">
            </x-forms.tags>
        </div>
    </x-grid>
</x-grid>
