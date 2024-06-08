<x-form :action="['modules.update', $campaign, $entityType->id]" method="PATCH" class="w-full max-w-lg" class="ajax-subform">
    @include('partials.forms.form', [
        'title' => __('campaigns/modules.rename.title', ['module' => __('entities.' . $entityType->code)]),
        'content' => 'campaigns.modules._form',
        'dialog' => true,
    ])
</x-form>

