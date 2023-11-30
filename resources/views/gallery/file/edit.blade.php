<?php /** @var \App\Models\Image $image */
$imageCount = 0;
?>
@can('edit', [$image, $campaign])
{!! Form::model($image, ['route' => ['images.update', $campaign, $image], 'method' => 'PUT', 'class' => 'flex flex-col gap-5']) !!}
@endcan
@include('partials.forms.form', [
    'title' => $image->name,
    'content' => 'gallery.file._form',
    'submit' => __('campaigns/gallery.actions.save'),
    'dialog' => true,
    'actions' => 'gallery.file._actions',
    'deleteID' => auth()->user()->can('delete', [$image, $campaign]) && ($image->isFolder() || $image->hasNoFolders()) ? '#delete-confirm-form' : null,
])
@can('edit', [$image, $campaign])
{!! Form::close() !!}

@if(!$image->isFolder() || $image->hasNoFolders())
    {!! Form::open(['method' => 'DELETE','route' => ['images.destroy', $campaign, $image->id], 'style'=>'display:inline', 'id' => 'delete-confirm-form']) !!}
    {!! Form::close() !!}
@endif
@endcan
