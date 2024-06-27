<x-form :action="['characters.races.save', $campaign, $character]">
    @include('partials.forms.form', [
        'title' => __('characters.races.title', ['name' => $character->name]),
        'content' => 'characters.races._reorder',
        'dialog' => true,
    ])
</x-form>
