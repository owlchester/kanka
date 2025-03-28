<x-form :action="['campaign.sidebar.image-save', $campaign]" files>
    @include('partials.forms._dialog', [
        'title' => __('campaigns.fields.image'),
        'content' => 'campaigns.forms.modals._image',
        'submit' => __('crud.actions.apply')
    ])
</x-form>
