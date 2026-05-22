<?php

namespace App\Models;

use App\Services\Auth\DeviceService;
use Exception;
use PragmaRX\Google2FALaravel\Support\Authenticator;

class OTPAuthentication extends Authenticator
{
    protected function canPassWithoutCheckingOTP(): bool
    {
        if (! isset($this->getUser()->passwordSecurity)) {
            return true;
        }

        return ! $this->getUser()->passwordSecurity->google2fa_enable
            || ! $this->isEnabled()
            || $this->noUserIsAuthenticated()
            || $this->twoFactorAuthStillValid()
            || $this->deviceIsVerified();
    }

    public function login(): void
    {
        parent::login();
        $this->markDeviceVerified();
    }

    protected function getGoogle2FaSecretkey(): mixed
    {
        try {
            $secret = $this->getUser()->passwordSecurity->{$this->config('otp_secret_column')};
        } catch (Exception) {
            $secret = $this->getUser()->passwordSecurity;
        }

        if (empty($secret)) {
            return redirect()->action('PasswordSecurityController@generate2faSecretCode');
        }

        return $secret;
    }

    private function deviceIsVerified(): bool
    {
        $device = app(DeviceService::class)->findForUser($this->getUser());

        return $device !== null && $device->isTwoFactorVerified();
    }

    private function markDeviceVerified(): void
    {
        $device = app(DeviceService::class)->findForUser($this->getUser());

        $device?->update(['two_factor_verified_at' => now()]);
    }
}
