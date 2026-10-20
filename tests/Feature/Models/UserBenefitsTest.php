<?php

use App\Models\Pledge;
use App\Models\Role;

it('uses the configured standard benefit limits', function (string $pledge, int $expected) {
    $this->asUser();
    $user = auth()->user();
    $user->roles()->syncWithoutDetaching([
        Role::query()->firstWhere('name', Pledge::ROLE)?->id
            ?? Role::forceCreate([
                'name' => Pledge::ROLE,
                'display_name' => 'Patreon',
            ])->id,
    ]);
    $user->forceFill(['pledge' => $pledge])->save();

    $user = $user->fresh();

    expect($user->maxBenefits())->toBe($expected);
})->with([
    'kobold' => [Pledge::KOBOLD, 0],
    'goblin' => [Pledge::GOBLIN, 0],
    'owlbear' => [Pledge::OWLBEAR, 1],
    'wyvern' => [Pledge::WYVERN, 3],
    'elemental' => [Pledge::ELEMENTAL, 7],
]);

it('uses the configured legacy benefit limits', function () {
    $this->asUser();
    $user = auth()->user();
    $user->roles()->syncWithoutDetaching([
        Role::query()->firstWhere('name', Pledge::ROLE)?->id
            ?? Role::forceCreate([
                'name' => Pledge::ROLE,
                'display_name' => 'Patreon',
            ])->id,
    ]);
    $user->forceFill([
        'pledge' => Pledge::ELEMENTAL,
        'settings' => ['grandfathered_boost' => 1],
    ])->save();

    expect($user->fresh()->maxBenefits())->toBe(10);
});
