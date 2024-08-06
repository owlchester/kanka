<x-form :action="['characters.families.save', $campaign, $character]">
    @include('partials.forms.form', [
        'title' => __('characters.families.title', ['name' => $character->name]),
        'content' => 'characters.families._reorder',
        'dialog' => true,
    ])
</x-form>
