<?php

use App\Models\User;
use App\Services\CountryService;
use App\Services\Users\CurrencyService;

it('defaults users in additional European markets to EUR', function (string $country) {
    $user = User::factory()->create(['settings' => []]);
    $countryService = Mockery::mock(CountryService::class);
    $countryService->shouldReceive('getCountry')->once()->andReturn($country);

    (new CurrencyService($countryService))->user($user)->setDefaultCurrency();

    expect($user->fresh()->currency())->toBe('eur');
})->with([
    'Andorra' => 'AD',
    'Bulgaria' => 'BG',
    'Switzerland' => 'CH',
    'Czechia' => 'CZ',
    'Hungary' => 'HU',
    'Iceland' => 'IS',
    'Liechtenstein' => 'LI',
    'Monaco' => 'MC',
    'Montenegro' => 'ME',
    'Norway' => 'NO',
    'Poland' => 'PL',
    'Romania' => 'RO',
    'San Marino' => 'SM',
    'Sweden' => 'SE',
    'Kosovo' => 'XK',
    'Vatican City' => 'VA',
]);

it('keeps USD as the implicit default outside supported regions', function () {
    $user = User::factory()->create(['settings' => []]);
    $countryService = Mockery::mock(CountryService::class);
    $countryService->shouldReceive('getCountry')->once()->andReturn('US');

    (new CurrencyService($countryService))->user($user)->setDefaultCurrency();

    expect($user->fresh()->currency())->toBe('usd');
});

it('preserves a saved currency preference', function () {
    $user = User::factory()->create(['settings' => ['currency' => 'usd']]);
    $countryService = Mockery::mock(CountryService::class);
    $countryService->shouldNotReceive('getCountry');

    (new CurrencyService($countryService))->user($user)->setDefaultCurrency();

    expect($user->fresh()->currency())->toBe('usd');
});
