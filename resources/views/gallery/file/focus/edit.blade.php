@include('partials.forms._dialog', [
    'title' => $image->name,
    'content' => 'gallery.file.focus._form',
    'articleClass' => 'container',
    'actions' => 'gallery.file.focus._actions',
])
