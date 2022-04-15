<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LocaleChange
{
    /**
     * List of languages that are no longer available and should redirect to english
     * @var string[]
     */
    protected $disabledLangs = ['he'];

    /**
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Never bother with any of these requests
        if ($request->is(
                'subscription-api/*',
                'feeds/*',
                '*/sitemap.xml',
                'oauth/*')) {
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
            if (in_array($locale, $this->disabledLangs)) {
                $locale = 'en';
            }
            $user = Auth::user();
            if (!empty($change)) {
                // Changing locale, save the new one
                $user->update(['locale' => $locale]);
                return redirect()->to($request->url());
            } elseif ($user->locale != $locale) {
                // If the locale is empty, we need to set it.
                if (empty($user->locale)) {
                    $user->locale = $locale;
                    $user->save();
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
            $targetUrl = LaravelLocalization::getLocalizedURL('en');
            if (config('app.force_https') && !Str::startsWith('https', $targetUrl)) {
                $targetUrl = Str::replaceFirst('http://', 'https://', $targetUrl);
            }
            // Permanent redirection to the home page
            return redirect($targetUrl, 301);
        }

        return $next($request);
    }
}
