<?php

use App\Models\Pledge;
use App\Models\Role;
use App\Models\User;
use App\Services\LimitService;

it('gives admin users a higher upload limit than standard users', function () {
    $user = User::factory()->create();

    $role = Role::where('name', 'admin')->first() ?? new Role;
    if (! $role->exists) {
        $role->name = 'admin';
        $role->display_name = 'Administrator';
        $role->save();
    }
    $user->roles()->attach($role->id);

    $size = app(LimitService::class)->user($user)->upload();

    expect($size)->toBe(config('limits.filesize.image.admin') * 1024);
});

it('does not lower the upload limit for admins who already have a higher pledge tier', function () {
    $user = User::factory()->create(['pledge' => Pledge::ELEMENTAL]);

    $role = Role::where('name', 'admin')->first() ?? new Role;
    if (! $role->exists) {
        $role->name = 'admin';
        $role->display_name = 'Administrator';
        $role->save();
    }
    $user->roles()->attach($role->id);

    $size = app(LimitService::class)->user($user)->upload();

    expect($size)->toBe(config('limits.filesize.image.elemental') * 1024);
});

it('keeps the standard upload limit for non admin users', function () {
    $user = User::factory()->create();

    $size = app(LimitService::class)->user($user)->upload();

    expect($size)->toBe(config('limits.filesize.image.standard') * 1024);
});
