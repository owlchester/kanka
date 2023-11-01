{!! Form::open(['route' => ['campaign.gallery.folders.store', $campaign], 'method' => 'POST', 'class' => 'ajax-subform']) !!}
@include('partials.forms.form', [
    'title' => __('campaigns/gallery.new_folder.title'),
    'content' => 'gallery.folders._form',
    'submit' => __('crud.create'),
    'dialog' => true,
])
@if(!empty($folder))
    {!! Form::hidden('folder_id', $folder->id) !!}
@endif
{!! Form::close() !!}
