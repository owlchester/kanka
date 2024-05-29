<?php

namespace App\Services\Users;

use App\Services\CountryService;
use App\Traits\UserAware;
use Illuminate\Support\Arr;

class CurrencyService
{
    use UserAware;

    protected CountryService $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    /**
     * Build a list of currencies available to the user
     * @return array
     */
    public function availableCurrencies(): array
    {
        // USD and EUR are always available
        $currencies = [
            'usd' => __('settings.subscription.currencies.usd'),
            'eur' => __('settings.subscription.currencies.eur'),
        ];
        // Brazil
        if ($this->countryService->getCountry() === 'BR' || auth()->user()->currency() === 'brl') {
            $currencies['brl'] = __('settings.subscription.currencies.brl');
        }
        return $currencies;
    }

    public function setDefaultCurrency(): void
    {
        // If the user has defined their preferred currency, we use that
        if (Arr::has($this->user->settings, 'currency')) {
            return;
        }

        $country = $this->countryService->getCountry();
        $europe = [
            // EuroZone
            'AT', 'BE', 'HR', 'CY', 'EE', 'FI', 'FR', 'DE', 'GR', 'IE',
            'IT', 'LV', 'LT', 'LU', 'MT', 'NL', 'PT', 'SI', 'SK', 'ES',
            // Pegged to the EUR
            'DK',
        ];
        $currency = null;
        if ($country === 'BR') {
            $currency = 'brl';
        } elseif (in_array($country, $europe)) {
            $currency = 'eur';
        }

        // Not one of our cases, let it default to USD
        if (empty($currency)) {
            return;
        }

        $settings = $this->user->settings;
        $settings['currency'] = $currency;
        $this->user->settings = $settings;
        $this->user->saveQuietly();
    }
}
