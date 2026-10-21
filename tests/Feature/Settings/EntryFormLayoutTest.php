<?php

it('defaults entry forms to legacy', function () {
    $this->asUser()->withCampaign();
    expect(auth()->user()->entry_form_layout)->toBe('legacy');
    $this->get(route('characters.create', [1]))->assertSuccessful()->assertDontSee('entry-workspace', false);
});

it('saves the entry form preference without replacing other settings', function (string $layout) {
    $this->asUser();
    auth()->user()->saveSettings(['editor' => 'tiptap'])->save();
    $this->patch(route('settings.appearance.update'), ['entry_form_layout' => $layout])->assertRedirect();
    expect(auth()->user()->fresh()->entry_form_layout)->toBe($layout)
        ->and(auth()->user()->fresh()->editor)->toBe('tiptap');
})->with(['modern', 'legacy']);

it('rejects an unknown entry form layout', function () {
    $this->asUser();
    $this->patch(route('settings.appearance.update'), ['entry_form_layout' => 'unknown'])
        ->assertSessionHasErrors('entry_form_layout');
    expect(auth()->user()->fresh()->entry_form_layout)->toBe('legacy');
});

it('offers the form layout setting in appearance', function () {
    $this->asUser();
    $this->get(route('settings.appearance'))->assertSuccessful()->assertSee('name="entry_form_layout"', false);
});
