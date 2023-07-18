<?php

namespace App\Services\Api;

use Illuminate\Support\Str;

class ApiHelperService
{
    protected bool $isSubdomain;

    /**
     * Determine if the current requested is executed on the api subdomain
     * @return bool
     */
    public function isSubdomain(): bool
    {
        if (isset($this->isSubdomain)) {
            return $this->isSubdomain;
        }

        $subdomainUrl = config('api.domain');
        return $this->isSubdomain = !empty($subdomainUrl) && Str::contains(request()->getHost(), $subdomainUrl);
    }

    /**
     * Fix a URL that points to the api subdomain to the kanka app domain
     * @param string $url
     * @return string
     */
    public function fixUrl(string $url): string
    {
        $replaceWith = Str::after(config('app.url'), '//');
        return Str::replaceFirst(config('api.domain'), $replaceWith, $url);
    }

    /**
     * Determine if the user is currently using the API, which can be the old api/* routes,
     * or in the new api subdomain in prod
     * @return bool
     */
    public function isApi(): bool
    {
        return request()->is('api/*') || $this->isSubdomain();
    }
}
