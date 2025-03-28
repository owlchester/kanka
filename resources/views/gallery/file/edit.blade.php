<?php /** @var \App\Models\Image $image */
$imageCount = 0;
?>
@can('edit', [$image, $campaign])
    <x-form :action="['images.update', $campaign, $image]" method="PUT" class="flex flex-col gap-5">
        @include('partials.forms._dialog', [
            'title' => $image->name,
            'content' => 'gallery.file._form',
            'submit' => __('campaigns/gallery.actions.save'),
            'actions' => 'gallery.file._actions',
            'deleteID' => auth()->user()->can('delete', [$image, $campaign]) && ($image->isFolder() || $image->hasNoFolders()) ? '#delete-confirm-form' : null,
        ])
    </x-form>
    @if(!$image->isFolder() || $image->hasNoFolders())
        <x-form method="DELETE" :action="['images.destroy', $campaign, $image->id]" id="delete-confirm-form" />
    @endif
@else
@include('partials.forms._dialog', [
    'title' => $image->name,
    'content' => 'gallery.file._form',
    'submit' => __('campaigns/gallery.actions.save'),
    'actions' => 'gallery.file._actions',
    'deleteID' => auth()->user()->can('delete', [$image, $campaign]) && ($image->isFolder() || $image->hasNoFolders()) ? '#delete-confirm-form' : null,
])
@endcan
