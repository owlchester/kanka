<?php

it('environment:testing', function () {
    expect(env('APP_ENV'))->toBe('testing');
});

it('environment:db', function () {
    expect(env('DB_CONNECTION'))->toBe('sqlite')
        ->and(env('DB_DATABASE'))->toBe(':memory:')
    ->and(env('DB_LOGS_DATABASE'))->toBeEmpty();
});
