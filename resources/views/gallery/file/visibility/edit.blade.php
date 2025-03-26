
<x-form :action="['gallery.file.visibility-save', $campaign, $image]" method="PATCH" class="flex flex-col gap-5">
@include('partials.forms._dialog', [
    'title' => $image->name,
    'content' => 'gallery.file.visibility._form',
    'articleClass' => 'container',
    #'actions' => 'gallery.file.visibility._actions',
])
</x-form>
