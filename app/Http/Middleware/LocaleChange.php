<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LocaleChange
{
    /**
     * List of languages that are no longer available and should redirect to english
     */
    protected array $disabledLangs = ['he', 'hr', 'hu', 'ca', 'gl'];

    /**
     * @return RedirectResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Never bother with any of these requests
        if (
            $request->is(
                'subscription-api/*',
                'oauth/*'
            )
        ) {
            return $next($request);
        }

        // If it's not a get request, don't touch it either
        if (!$request->isMethod('get')) {
            $locale = $this->currentLocale();
            LaravelLocalization::setLocale($locale);
            return $next($request);
        }

        $locale = $this->currentLocale();
        LaravelLocalization::setLocale($locale);

        $new = $request->get('lang');
        if (!empty($new) && $this->valid($new)) {
            return $this->update($request, $new);
        }

        return $next($request);
    }

    protected function currentLocale(): string
    {
        if (auth()->check()) {
            return auth()->user()->locale;
        }

        // Unlogged users can change language, we keep it in a cookie
        $locale = Cookie::get('kanka_locale');
        return !empty($locale) && $this->valid($locale) ? $locale : 'en-US';
    }

    protected function update(Request $request, string $locale): RedirectResponse
    {
        if (auth()->check()) {
            /** @var User $user */
            $user = auth()->user();
            $user->locale = $locale;
            $user->saveQuietly();
            return redirect()->to($request->path());
        } else {
            return redirect()->to($request->path())->withCookie(
                Cookie::make('kanka_locale', $locale)
            );
        }
    }

    protected function valid(string $locale): bool
    {
        $locales = LaravelLocalization::getSupportedLocales();
        if (!in_array($locale, array_keys($locales))) {
            return false;
        }

        // Remove old
        return !in_array($locale, $this->disabledLangs);
    }

    protected function fallbackUrl(): string
    {
        $targetUrl = LaravelLocalization::getLocalizedURL('en');
        // Prod is behind a reverse proxy that doesn't know about https
        if (config('app.force_https') && !Str::startsWith('https', $targetUrl)) {
            $targetUrl = Str::replaceFirst('http://', 'https://', $targetUrl);
        }

        return $targetUrl;
    }
}
