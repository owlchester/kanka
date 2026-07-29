<?php

it('strips html tags from the name when updating profile settings', function () {
    $this->asUser();
    $user = auth()->user();

    $this->patch(route('settings.profile-process'), [
        'name' => '<script>alert(1)</script>Evil',
        'has_last_login_sharing' => 0,
    ])->assertRedirect();

    expect($user->fresh()->name)->toBe('alert(1)Evil');
});

it('does not break the name field out of its attribute when the name has a quote', function () {
    $this->asUser();
    $user = auth()->user();
    $user->update(['name' => 'John "The Rock" Doe']);

    $this->get(route('settings.profile'))
        ->assertOk()
        ->assertSee('name="name" maxlength="191"', false)
        ->assertSee('value="John &quot;The Rock&quot; Doe"', false)
        ->assertDontSee('value="John "The Rock" Doe"', false);
});
