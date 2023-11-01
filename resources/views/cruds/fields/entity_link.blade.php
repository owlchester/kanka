<?php /** @var \App\Models\Entity $entity */?>
@if ($entity)
    <x-forms.field field="entity" :label="__('crud.fields.entity')">
        {!! $entity->tooltipedLink(null, true, 'data-placement="bottom"') !!}
    </x-forms.field>
@endif
