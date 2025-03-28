<x-form :action="['campaign.gallery.folders.store', $campaign]">
    @include('partials.forms._dialog', [
        'title' => __('campaigns/gallery.new_folder.title'),
        'content' => 'gallery.folders._form',
        'submit' => __('crud.create'),
    ])
    @if(!empty($folder))
        <input type="hidden" name="folder_id" value="{{ $folder->id }}" />
    @endif
</x-form>
