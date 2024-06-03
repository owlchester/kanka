{!! Form::open(['route' => ['campaign.gallery.folders.store', $campaign], 'method' => 'POST', 'class' => 'ajax-subform']) !!}
@include('partials.forms.form', [
    'title' => __('campaigns/gallery.new_folder.title'),
    'content' => 'gallery.folders._form',
    'submit' => __('crud.create'),
    'dialog' => true,
])
@if(!empty($folder))
    <input type="hidden" name="folder_id" value="{{ $folder->id }}" />
@endif
{!! Form::close() !!}
