<x-form :action="['characters.families.save', $campaign, $character]">
    @include('partials.forms._dialog', [
        'title' => __('characters.families.title2'),
        'content' => 'characters.families._reorder',
    ])
</x-form>
