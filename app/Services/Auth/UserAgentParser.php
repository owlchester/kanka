<?php

namespace App\Services\Auth;

class UserAgentParser
{
    public function parse(?string $userAgent): string
    {
        if (empty($userAgent)) {
            return __('settings/security.devices.unknown');
        }

        $browser = $this->parseBrowser($userAgent);
        $os = $this->parseOs($userAgent);

        if ($os) {
            return "{$browser} on {$os}";
        }

        return $browser;
    }

    private function parseBrowser(string $ua): string
    {
        if (str_contains($ua, 'Edg/') || str_contains($ua, 'Edge/')) {
            return 'Edge';
        }
        if (str_contains($ua, 'OPR/') || str_contains($ua, 'Opera/')) {
            return 'Opera';
        }
        if (str_contains($ua, 'Firefox/')) {
            return 'Firefox';
        }
        if (str_contains($ua, 'Chrome/')) {
            return 'Chrome';
        }
        if (str_contains($ua, 'Safari/') && str_contains($ua, 'Version/')) {
            return 'Safari';
        }

        return __('settings/security.devices.unknown_browser');
    }

    private function parseOs(string $ua): ?string
    {
        if (str_contains($ua, 'iPhone') || str_contains($ua, 'iPad')) {
            return 'iOS';
        }
        if (str_contains($ua, 'Android')) {
            return 'Android';
        }
        if (str_contains($ua, 'Macintosh') || str_contains($ua, 'Mac OS X')) {
            return 'macOS';
        }
        if (str_contains($ua, 'Windows')) {
            return 'Windows';
        }
        if (str_contains($ua, 'Linux')) {
            return 'Linux';
        }

        return null;
    }
}
