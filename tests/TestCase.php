<?php

namespace Tests;

use Mcamara\LaravelLocalization\LaravelLocalization;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    protected function setUp(): void
    {
        parent::setUp();
        putenv(LaravelLocalization::ENV_ROUTE_KEY . '=' . 'en');
    }
}
