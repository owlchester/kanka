<?php

namespace App\Services\Api;

use Illuminate\Support\Str;

class ApiHelperService
{
    protected bool $cached = false;
    protected bool $isSubdomain;

    /**
     * Determine if the current requested is executed on the api subdomain
     * @return bool
     */
    public function isSubdomain(): bool
    {
        if ($this->cached) {
            return $this->isSubdomain;
        }

        $subdomainUrl = config('api.domain');
        $this->cached = true;
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
}
