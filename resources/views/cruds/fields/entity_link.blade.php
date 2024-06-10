<?php /** @var \App\Models\Entity $entity */?>
@if ($entity)
    @dd('Unknow call')
    <x-forms.field field="entity" :label="__('crud.fields.entity')">
        <x-entity-link
            :entity="$entity"
            :campaign="$campaign"
            bottom />
    </x-forms.field>
@endif
