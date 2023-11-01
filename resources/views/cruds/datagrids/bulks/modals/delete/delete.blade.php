<?php /** @var \App\Datagrids\Datagrid $datagrid */?>

{!! Form::open([
    'url' => route('bulk.delete.apply', [$campaign, $entityType]),
    'method' => 'POST'])
!!}

@include('partials.forms.form', [
    'title' =>__('crud.delete_modal.title'),
    'content' => 'cruds.datagrids.bulks.modals.delete._form',
    'footer' => 'cruds.datagrids.bulks.modals.delete._footer',
    'dialog' => true,
])
<input type="hidden" name="models" />
{!! Form::close() !!}
