<x-form :action="['modules.update', $campaign, $entityType->id]" method="PATCH" class="w-full max-w-lg">
    @include('partials.forms._dialog', [
        'title' => __('campaigns/modules.rename.title', ['module' => __('entities.' . $entityType->code)]),
        'content' => 'campaigns.modules._form',
        'submit' => __('crud.actions.save-changes')
    ])
</x-form>

