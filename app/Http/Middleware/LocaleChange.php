<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LocaleChange
{
    /**
     * List of languages that are no longer available and should redirect to english
     */
    protected array $disabledLangs = ['he', 'hr', 'hu', 'ca', 'gl'];

    /**
     * @param Request $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Never bother with any of these requests
        if (
            $request->is(
                'subscription-api/*',
                'feeds/*',
                '*/sitemap.xml',
                'oauth/*'
            )
        ) {
            return $next($request);
        }

        // If it's not a get request, don't touch it either
        if (!$request->isMethod('get')) {
            return $next($request);
        }

        // If it's a logged in user, we might go change their settings
        $locale = LaravelLocalization::getCurrentLocale();

        if (auth()->check()) {
            $change = $request->query('updateLocale');
            $to = $request->url();
            // Trying to access a no longer supported language, redirect
            if (in_array($locale, $this->disabledLangs)) {
                $locale = 'en';
                $change = true;
                $to = $this->fallbackUrl();
            }
            /** @var User $user */
            $user = auth()->user();
            if (!empty($change)) {
                // Changing locale, save the new one
                $user->updateQuietly(['locale' => $locale]);
                return redirect()->to($to);
            } elseif ($user->locale != $locale) {
                // If the locale is empty, we need to set it.
                if (empty($user->locale)) {
                    $user->locale = $locale;
                    $user->saveQuietly();
                } elseif (in_array($user->locale, $this->disabledLangs)) {
                    $user->locale = 'en';
                    $user->saveQuietly();
                }
                // Redirect to the user's normal locale
                $targetUrl = LaravelLocalization::getLocalizedURL($user->locale);
                // Because the request comes from the frontend machines and the https is stripped,
                if (config('app.force_https') && !Str::startsWith('https', $targetUrl)) {
                    $targetUrl = Str::replaceFirst('http://', 'https://', $targetUrl);
                }
                return redirect()->to($targetUrl);
            }
        } elseif (in_array($locale, $this->disabledLangs)) {
            // Permanent redirection to the home page
            return redirect($this->fallbackUrl(), 301);
        }

        return $next($request);
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
