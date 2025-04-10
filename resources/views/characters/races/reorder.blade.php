<x-form :action="['characters.races.save', $campaign, $character]">
    @include('partials.forms._dialog', [
        'title' => __('characters.races.title2'),
        'content' => 'characters.races._reorder',
    ])
</x-form>
