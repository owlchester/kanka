<x-form :action="['bulk.copy-to-campaign.apply', $campaign, $entityType]" direct>
    @include('partials.forms._dialog', [
        'title' => __('crud.copy_to_campaign.bulk_title'),
        'content' => 'cruds.datagrids.bulks.modals.forms._copy',
        'submit' => __('crud.actions.copy_to_campaign'),
    ])
    @if (!empty($entities))
        @foreach ($entities as $id)
            <input type="hidden" name="entities[]" value="{{ $id }}" />
        @endforeach
    @else
        <input type="hidden" name="models" />
    @endif
</x-form>
