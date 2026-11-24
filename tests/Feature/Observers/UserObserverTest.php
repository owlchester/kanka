<?php

use App\Models\User;

it('defaults new users to the modern editor and form', function () {
    $user = User::factory()->create();

    expect($user->editor)->toBe('tiptap')
        ->and($user->entry_form_layout)->toBe('modern');
});

it('preserves explicitly provided settings when creating users', function () {
    $user = User::factory()->create([
        'settings' => [
            'editor' => 'legacy',
            'entry_form_layout' => 'legacy',
            'custom_setting' => true,
        ],
    ]);

    expect($user->editor)->toBe('legacy')
        ->and($user->entry_form_layout)->toBe('legacy')
        ->and($user->settings['custom_setting'])->toBeTrue();
});
