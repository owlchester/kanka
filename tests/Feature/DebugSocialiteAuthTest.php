<?php

use App\Models\User;
use Illuminate\Support\Facades\Config;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;

beforeEach(function () {
    Config::set('auth.register_enabled', true);
});

it('returns 404 when debug mode is disabled', function () {
    Config::set('app.debug', false);

    $this->get('/debug/auth/google')->assertNotFound();
});

it('redirects to login for an invalid provider in debug mode', function () {
    Config::set('app.debug', true);

    $this->get('/debug/auth/github')->assertRedirect(route('login'));
});

it('creates and logs in a new user via fake google oauth', function () {
    Config::set('app.debug', true);
    Socialite::fake('google', (new SocialiteUser)->map([
        'id' => 'debug_google_user',
        'name' => 'Debug Google User',
        'email' => 'debug+google@kanka.io',
    ]));

    $this->get('/debug/auth/google')
        ->assertRedirect(route('home'));

    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', ['email' => 'debug+google@kanka.io', 'provider' => 'google']);
});

it('logs in an existing provider user via fake facebook oauth', function () {
    Config::set('app.debug', true);
    $user = User::factory()->create([
        'email' => 'debug+facebook@kanka.io',
        'provider' => 'facebook',
        'provider_id' => 'debug_facebook_user',
    ]);

    Socialite::fake('facebook', (new SocialiteUser)->map([
        'id' => 'debug_facebook_user',
        'name' => 'Debug Facebook User',
        'email' => 'debug+facebook@kanka.io',
    ]));

    $this->get('/debug/auth/facebook')
        ->assertRedirect(route('home'));

    $this->assertAuthenticatedAs($user);
});
