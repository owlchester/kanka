<x-form :action="['bulk.templates.apply', $campaign, $entityType]" direct>
    @include('partials.forms._dialog', [
        'title' => __('crud.bulk_templates.bulk_title'),
        'content' => 'cruds.datagrids.bulks.modals.forms._templates',
        'submit' => __('crud.actions.apply'),
    ])
    @if (!empty($entities))
        @foreach ($entities as $id)
            <input type="hidden" name="entities[]" value="{{ $id }}" />
        @endforeach
    @else
        <input type="hidden" name="models" />
    @endif
</x-form>
