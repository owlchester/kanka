<?php

namespace App\Providers;

use App\Http\Validators\HashValidator;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Cashier\Cashier;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Process\Process;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Fix setups for utf8_mb4 mysql strings (emoji support)
        Schema::defaultStringLength(191);

        $this->registerDevelopWarning();

        $this->registerWebObservers();
        Cashier::useCustomerModel(User::class);

        if (config('app.lazy')) {
            Model::preventLazyLoading();
        }

        Validator::resolver(function ($translator, $data, $rules, $messages) {
            return new HashValidator($translator, $data, $rules, $messages);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {}

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

    /**
     * Register web observers (ie not running in console)
     * Kanka uses a lot of observers because they offer some magic, but
     * they also make a lot of stuff break.
     */
    protected function registerWebObservers()
    {
        // When in console (queue, commands), we don't want observers to trigger
        if (app()->runningInConsole() && ! app()->runningUnitTests()) {
            return;
        }

        // In production, we want URLs to be HTTPS for pagination and redirects
        if ($this->app->isProduction() || $this->app->environment('qa')) {
            \URL::forceScheme('https');
        }

        // Tell laravel that we are using bootstrap 3 to style the paginators
        // Paginator::useTailwind();

        if (request()->has('_debug_perm') && config('app.debug')) {
            // Add in boot function
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
