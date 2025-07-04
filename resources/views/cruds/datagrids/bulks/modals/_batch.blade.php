<x-form :action="['bulk.batch.apply', $campaign, $entityType]" direct>
    @include('partials.forms._dialog', [
        'title' => __('crud.bulk.edit.title'),
        'content' => 'cruds.datagrids.bulks.modals.forms._batch',
    ])
    @foreach ($entities as $id)
        <input type="hidden" name="entities[]" value="{{ $id }}" />
    @endforeach
</x-form>
