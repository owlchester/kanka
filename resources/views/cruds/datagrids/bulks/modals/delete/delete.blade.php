<?php /** @var \App\Datagrids\Datagrid $datagrid */?>

<x-form :action="['bulk.delete.apply', $campaign, $entityType]" direct>
    @include('partials.forms._dialog', [
        'title' =>__('crud.delete_modal.title'),
        'content' => 'cruds.datagrids.bulks.modals.delete._form',
        'footer' => 'cruds.datagrids.bulks.modals.delete._footer',
    ])
    @if (!empty($entities))
        @foreach ($entities as $id)
            <input type="hidden" name="entities[]" value="{{ $id }}" />
        @endforeach
    @else
        <input type="hidden" name="models" />
    @endif
</x-form>
