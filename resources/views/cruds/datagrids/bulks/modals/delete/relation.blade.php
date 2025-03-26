<?php /** @var \App\Datagrids\Datagrid $datagrid */?>

<x-form :action="['bulk.delete-relations.apply', $campaign]" direct>
    @include('partials.forms._dialog', [
        'title' =>__('crud.delete_modal.title'),
        'content' => 'cruds.datagrids.bulks.modals.delete._form',
        'footer' => 'cruds.datagrids.bulks.modals.delete._footer',
    ])
    <input type="hidden" name="models" />
</x-form>
