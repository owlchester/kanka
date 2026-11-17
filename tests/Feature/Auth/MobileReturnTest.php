<?php

use App\Models\User;
use Illuminate\Support\Facades\URL;

it('preserves a signed world page return destination on authentication pages', function (string $route) {
    config(['auth.register_enabled' => true]);
    $target = '/w/test-world/t/1?name=Mira';

    $this->get(URL::signedRoute($route, ['return_to' => $target]))
        ->assertSuccessful()
        ->assertSessionHas('login_redirect', $target);
})->with(['login', 'register']);

it('returns a user to the viewed world page after logging in', function () {
    config(['google2fa.enabled' => false]);
    $user = User::factory()->create();
    $target = '/w/test-world/t/1?name=Mira';

    $this->get(URL::signedRoute('login', ['return_to' => $target]))
        ->assertSuccessful();

    $this->post(route('login'), ['email' => $user->email, 'password' => 'password'])
        ->assertRedirect($target);

    $this->assertAuthenticatedAs($user);
});

it('ignores untrusted authentication return destinations', function (string $target, bool $signed) {
    $url = $signed
        ? URL::signedRoute('login', ['return_to' => $target])
        : route('login', ['return_to' => $target]);

    $this->get($url)
        ->assertSuccessful()
        ->assertSessionMissing('login_redirect');
})->with([
    'unsigned world page' => ['/w/test-world/t/1', false],
    'external URL' => ['https://example.com', true],
    'protocol relative URL' => ['//example.com', true],
    'backslash path' => ['/w/\\example.com', true],
]);

it('ignores tampered signed authentication return links', function () {
    $url = URL::signedRoute('login', ['return_to' => '/w/test-world/t/1']);
    $url .= '&return_to=' . urlencode('/w/other-world/t/1');

    $this->get($url)
        ->assertSuccessful()
        ->assertSessionMissing('login_redirect');
});
