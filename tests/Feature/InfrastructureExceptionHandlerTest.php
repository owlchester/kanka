<?php

use App\Exceptions\Handler;
use App\Models\User;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\ErrorHandler\Error\FatalError;

it('renders the infrastructure page for an uncaught PDO connection fatal error', function () {
    $exception = new FatalError(
        "Uncaught PDOException: SQLSTATE[HY000] [2002] Connection refused in /app/vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:70\nStack trace:\n#0 {main}\n  thrown",
        0,
        ['type' => E_ERROR, 'message' => 'uncaught exception', 'file' => '/app/index.php', 'line' => 1],
    );

    $response = app(Handler::class)->render(Request::create('/'), $exception);
    $content = $response->getContent();

    expect($response->getStatusCode())->toBe(200)
        ->and($response->getOriginalContent()->name())->toBe('errors.infrastructure')
        ->and($content)->toContain('Infrastructure error')
        ->and($content)->toContain('unplanned infrastructure outage')
        ->and($content)->not->toContain('<footer');
});

it('does not classify arbitrary fatal errors or PDO query failures as infrastructure outages', function (string $message) {
    $exception = new FatalError(
        $message,
        0,
        ['type' => E_ERROR, 'message' => $message, 'file' => '/app/index.php', 'line' => 1],
    );

    $response = app(Handler::class)->render(Request::create('/'), $exception);

    expect($response->getStatusCode())->not->toBe(200);
})->with([
    'an unrelated fatal mentioning the phrase' => 'Uncaught Error: Connection refused while reading a file',
    'a non-connection PDO SQLSTATE' => 'Uncaught PDOException: SQLSTATE[42S02]: Base table or view not found',
]);

it('still recognizes direct and wrapped PDO connection exceptions', function () {
    $pdo = new PDOException('SQLSTATE[HY000] [2002] Connection refused');
    $handler = app(Handler::class);

    foreach ([$pdo, new RuntimeException('query failed', 0, $pdo)] as $exception) {
        $response = $handler->render(Request::create('/'), $exception);

        expect($response->getStatusCode())->toBe(200)
            ->and($response->getContent())->toContain('Infrastructure error');
    }
});

it('renders infrastructure failures when the authenticated session user lookup fails', function (bool $debug) {
    config(['app.debug' => $debug]);

    $user = User::factory()->create();
    $provider = Mockery::mock(UserProvider::class);
    $provider->shouldReceive('retrieveById')->with($user->id)->andReturnUsing(function () use ($user): never {
        throw new QueryException('mysql', 'select * from users where id = ?', [$user->id], new PDOException('SQLSTATE[HY000] [2002] Connection refused'));
    });

    $guard = Auth::guard('web');
    $guard->setProvider($provider);
    $guard->forgetUser();

    Route::middleware(['web', 'auth'])->get('/_test/infrastructure-outage', fn () => 'authenticated');

    $this->withSession([$guard->getName() => $user->id])
        ->get('/_test/infrastructure-outage')
        ->assertOk()
        ->assertSee('Infrastructure error');
})->with([false, true]);
