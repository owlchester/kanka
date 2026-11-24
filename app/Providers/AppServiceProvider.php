<?php

namespace App\Providers;

use App\Auth\PassportTokenGuard;
use App\Http\Validators\HashValidator;
use App\Jobs\Search\MakeSearchable;
use App\Models\User;
use App\Services\AttributeMentionService;
use App\Services\BreadcrumbService;
use App\Services\Caches\AdCacheService;
use App\Services\Caches\CampaignCacheService;
use App\Services\Caches\UserCacheService;
use App\Services\Campaign\Import\ImportIdMapper;
use App\Services\Campaign\ModuleService;
use App\Services\DashboardService;
use App\Services\DomainService;
use App\Services\LimitService;
use App\Services\Logs\ApiLogService;
use App\View\Composers\EntryWorkspaceComposer;
use Exception;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Cashier\Cashier;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Passport;
use Laravel\Passport\PassportUserProvider;
use Laravel\Scout\Scout;
use League\OAuth2\Server\ResourceServer;
use Livewire\Livewire;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Process\Process;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->scoped(AdCacheService::class);
        $this->app->scoped(ApiLogService::class);
        $this->app->scoped(AttributeMentionService::class);
        $this->app->scoped(BreadcrumbService::class);
        $this->app->scoped(CampaignCacheService::class);
        $this->app->scoped(DashboardService::class);
        $this->app->scoped(DomainService::class);
        $this->app->scoped(ImportIdMapper::class);
        $this->app->scoped(LimitService::class);
        $this->app->scoped(ModuleService::class);
        $this->app->scoped(UserCacheService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Fix setups for utf8_mb4 mysql strings (emoji support)
        Schema::defaultStringLength(191);
        View::composer('entities.forms._workspace', EntryWorkspaceComposer::class);

        Passport::$clientUuids = false;
        Passport::authorizationView('vendor.passport.authorize');

        // Override Passport's TokenGuard to fix a false positive in 13.7 where
        // personal access tokens are rejected when user ID == client ID.
        Auth::resolved(function ($auth): void {
            $auth->extend('passport', fn ($app, $name, array $config) => tap(
                new PassportTokenGuard(
                    app(ResourceServer::class),
                    new PassportUserProvider(Auth::createUserProvider($config['provider']), $config['provider']),
                    app(ClientRepository::class),
                    app(Encrypter::class),
                    app('request'),
                ),
                fn ($guard) => app()->refresh('request', $guard, 'setRequest')
            ));
        });

        $this->registerDevelopWarning();
        $this->bootWeb();
        Cashier::useCustomerModel(User::class);
        Scout::makeSearchableUsing(MakeSearchable::class);

        if (config('app.lazy')) {
            Model::preventLazyLoading();
        }

        Validator::resolver(function ($translator, $data, $rules, $messages) {
            return new HashValidator($translator, $data, $rules, $messages);
        });

        Livewire::setUpdateRoute(function ($handle) {
            return Route::post('/livewire/update/{campaign?}', $handle)->middleware('web');
        });
    }

    protected function registerDevelopWarning()
    {
        if (! app()->runningInConsole()) {
            return;
        }
        if (config('app.ignore_develop_warning')) {
            return;
        }

        $path = base_path();
        $command = 'git symbolic-ref -q --short HEAD || git describe --tags --exact-match';
        if (class_exists('\Symfony\Component\Process\Process')) {
            try {
                // @phpstan-ignore-next-line
                if (method_exists(Process::class, 'fromShellCommandline')) {
                    $process = Process::fromShellCommandline($command, $path);
                } else {
                    $process = new Process([$command], $path);
                }

                $process->mustRun();
                $output = $process->getOutput();
            } catch (Exception $e) {
                // Silence errors
            }
        }

        if (! empty($output) && Str::startsWith($output, 'develop')) {
            throw new InvalidOptionException(
                "CONFIGURATION WARNING\n" .
                "You are currently running Kanka on the unstable @develop branch. This is unstable and WILL RESULT IN DATA LOSS.\n" .
                "If this isn't a mistake, add `APP_IGNORE_DEVELOP_WARNING=true` to your .env file."
            );
        }
    }

    protected function bootWeb(): void
    {
        if (app()->runningInConsole() && ! app()->runningUnitTests()) {
            return;
        }

        // In production, we want URLs to be HTTPS for pagination and redirects
        if ($this->app->isProduction() || $this->app->environment('qa')) {
            \URL::forceScheme('https');
        }

        if (request()->has('_debug_perm') && config('app.debug')) {
            DB::listen(function ($query) {
                $sql = $query->sql;
                foreach ($query->bindings as $key => $binding) {
                    $sql = preg_replace('/\?/', "'{$binding}'", $sql, 1);
                }
                dump($sql);
            });
        }
    }
}
