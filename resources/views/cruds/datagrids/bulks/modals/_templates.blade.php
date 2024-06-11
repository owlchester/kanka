<x-form :action="['bulk.templates.apply', $campaign, $entityType]" direct>
    @include('partials.forms.form', [
        'title' => __('crud.bulk_templates.bulk_title'),
        'content' => 'cruds.datagrids.bulks.modals.forms._templates',
        'submit' => __('crud.actions.apply'),
        'dialog' => true,
    ])
    <input type="hidden" name="models" />
</x-form>
