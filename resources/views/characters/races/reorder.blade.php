<x-form :action="['characters.races.save', $campaign, $character]">
    @include('partials.forms._dialog', [
        'title' => __('characters.races.title', ['name' => $character->name]),
        'content' => 'characters.races._reorder',
    ])
</x-form>
