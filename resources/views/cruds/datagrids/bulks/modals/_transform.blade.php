<x-form :action="['bulk.transform.apply', $campaign, $entityType]" direct>
    @include('partials.forms.form', [
        'title' => __('entities/transform.panel.bulk_title'),
        'content' => 'cruds.datagrids.bulks.modals.forms._transform',
        'submit' => __('entities/transform.actions.transform'),
        'dialog' => true,
    ])
    <input type="hidden" name="models" />
</x-form>
