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
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->is('subscription-api/*', 'feeds/*', '*/sitemap.xml') && !Auth::guest() && $request->isMethod('get')) {
            $change = $request->query('updateLocale');
            $locale = LaravelLocalization::getCurrentLocale();
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
                return redirect()->to(LaravelLocalization::getLocalizedURL($user->locale));
            }
        }

        return $next($request);
    }
}
