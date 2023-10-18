<?php /** @var \App\Models\Image $image */
$imageCount = 0;
?>
{!! Form::model($image, ['route' => ['images.update', $campaign, $image], 'method' => 'PUT', 'class' => 'flex flex-col gap-5']) !!}
@include('partials.forms.form', [
    'title' => $image->name,
    'content' => 'gallery.file._form',
    'submit' => __('campaigns/gallery.actions.save'),
    'dialog' => true,
    'actions' => 'gallery.file._actions',
    'deleteID' => $image->isFolder() || $image->hasNoFolders() ? '#delete-confirm-form' : null,
])
{!! Form::close() !!}

@if(!$image->isFolder() || $image->hasNoFolders())
    {!! Form::open(['method' => 'DELETE','route' => ['images.destroy', $campaign, $image->id], 'style'=>'display:inline', 'id' => 'delete-confirm-form']) !!}
    {!! Form::close() !!}
@endif
