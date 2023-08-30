@include('partials.forms.form', [
    'title' => $image->name,
    'content' => 'gallery.file.focus._form',
    'dialog' => true,
    'actions' => 'gallery.file.focus._actions',
])
