@inject('entityService', 'App\Services\EntityService')
<?php
$entityTypes = ['' => '', 'any' => __('bookmarks.random_types.any')];
$entities = $entityService->campaign($campaign)->getEnabledEntitiesSorted(false, ['bookmarks']);
$entityTypes = array_merge($entityTypes, $entities);
?>
<x-grid type="1/1">
    <x-helper :text="__('bookmarks.helpers.random')" />

    <x-grid>
        <x-forms.field field="random-type" :label="__('bookmarks.fields.random_type')">
            {!! Form::select('random_entity_type', $entityTypes, FormCopy::field('random_entity_type')->string(), ['class' => '']) !!}
        </x-forms.field>

        <input type="hidden" name="save_tags" value="1" />
        <x-forms.tags
            :campaign="$campaign"
            :model="$model ?? null">
        </x-forms.tags>
    </x-grid>
</x-grid>
