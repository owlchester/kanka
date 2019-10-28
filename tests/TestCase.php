<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Providers\ArtisanServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabaseState;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase {
        refreshTestDatabase as parentRefreshTestDatabase;
    }
    use CreatesApplication {
        createApplication as parentCreateApplication;
    }

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp()
    {
        if (isset($_ENV['APP_RUNNING_IN_CONSOLE'])) {
            if ($_ENV['APP_RUNNING_IN_CONSOLE'] == 1) {
                $_ENV['APP_RUNNING_IN_CONSOLE'] = 'true';
            }
        }

        if (!isset($_ENV['SKIP_DB_SETUP']) || $_ENV['SKIP_DB_SETUP'] == false) {
            $mysql = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], '', $_ENV['DB_PORT']);
            $mysql->query('DROP DATABASE IF EXISTS `' . $_ENV['DB_DATABASE'] . '`');
            $mysql->query('CREATE DATABASE `' . $_ENV['DB_DATABASE'] . '`');
        }

        parent::setUp();
        $this->artisan('db:seed');
        config(
            [
                'laravellocalization.hideDefaultLocaleInURL' => true,
                'laravellocalization.useAcceptLanguageHeader' => false
            ]
        );
    }

    protected function refreshTestDatabase()
    {
        if (!isset($_ENV['SKIP_DB_SETUP']) || $_ENV['SKIP_DB_SETUP'] == false) {
            RefreshDatabaseState::$migrated = false;
            $this->parentRefreshTestDatabase();
        } else {
            $this->beginDatabaseTransaction();
        }
    }

    public function createApplication()
    {
        $app = $this->parentCreateApplication();
        $this->clearCache();
        return $app;
    }

    protected function registerTestUser($doLogin = false): void
    {
        config(['laravellocalization.hideDefaultLocaleInURL' => true]);
        $user = User::create([
            'name' => 'Testuser',
            'email' => 'tester@testuser.ci',
            'password' => bcrypt('test123!')
        ]);

        self::assertEquals('Testuser', $user->name);

        if ($doLogin === true) {
            Auth::guard()->login($user);
        }
    }

    protected function registerTestUserFrontend(): void
    {
        $response = $this->post('register', [
            'name' => 'Testuser',
            'email' => 'tester@testuser.ci',
            'password' => 'test123!',
            'tos' => 1
        ]);

        $response->assertStatus(302);
    }

    protected function createDefaultUser(): User
    {
        return factory(User::class)->make(
            [
                'locale' => LaravelLocalization::getCurrentLocale(),
                'created_at' => Carbon::today()
            ]
        );
    }

    protected function clearCache()
    {
        $commands = ['clear-compiled', 'cache:clear', 'view:clear', 'config:clear', 'route:clear'];
        foreach ($commands as $command) {
            Artisan::call($command);
        }
    }
}
