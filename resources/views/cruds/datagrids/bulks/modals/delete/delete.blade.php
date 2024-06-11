<?php /** @var \App\Datagrids\Datagrid $datagrid */?>

<x-form :action="['bulk.delete.apply', $campaign, $entityType]" direct>
    @include('partials.forms.form', [
        'title' =>__('crud.delete_modal.title'),
        'content' => 'cruds.datagrids.bulks.modals.delete._form',
        'footer' => 'cruds.datagrids.bulks.modals.delete._footer',
        'dialog' => true,
    ])
    <input type="hidden" name="models" />
</x-form>
