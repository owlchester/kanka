<x-form :action="['bulk.transform.apply', $campaign, $entityType]" direct>
    @include('partials.forms._dialog', [
        'title' => __('entities/transform.panel.bulk_title'),
        'content' => 'cruds.datagrids.bulks.modals.forms._transform',
        'submit' => __('entities/transform.actions.transform'),
    ])
    @if (!empty($entities))
        @foreach ($entities as $id)
            <input type="hidden" name="entities[]" value="{{ $id }}" />
        @endforeach
    @else
        <input type="hidden" name="models" />
    @endif
</x-form>
