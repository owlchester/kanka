<x-form :action="['bulk.permissions.apply', $campaign, $entityType]" direct>
    @include('partials.forms._dialog', [
        'title' => __('crud.bulk.permissions.title'),
        'content' => 'cruds.datagrids.bulks.modals.forms._permissions',
        'submit' => __('crud.bulk.actions.permissions'),
    ])
    @if (!empty($entities))
        @foreach ($entities as $id)
            <input type="hidden" name="entities[]" value="{{ $id }}" />
        @endforeach
    @else
    <input type="hidden" name="models" />
    @endif
</x-form>
