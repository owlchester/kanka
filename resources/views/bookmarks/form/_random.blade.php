@inject('typeService', 'App\Services\Entity\TypeService')
@php
$entityTypes = ['' => '', 'any' => __('bookmarks.random_types.any')];
$entities = $typeService->campaign($campaign)->alphabetical()->plural()->permissionless()->exclude(['bookmark'])->singularKey()->labelled();
$entityTypes = array_merge($entityTypes, $entities);
@endphp


<x-grid type="1/1">
    <x-helper :text="__('bookmarks.helpers.random')" />

    <x-grid>
        <x-forms.field field="random-type" :label="__('bookmarks.fields.random_type')">
            {!! Form::select('random_entity_type', $entityTypes, FormCopy::field('random_entity_type')->string(), ['class' => '']) !!}
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
