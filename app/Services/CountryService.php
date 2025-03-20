<?php

namespace App\Services;

class CountryService
{
    /**
     * Get the user's country base on where they are making the request from
     */
    public function getCountry(): string
    {
        $country = config('app.default_country');
        if (isset($_SERVER['HTTP_CF_IPCOUNTRY'])) {
            $country = mb_substr($_SERVER['HTTP_CF_IPCOUNTRY'], 0, 6);
        }

        return $country;
    }

    /**
     * Get the user's currency based on the country they are making the request from
     */
    public function getCurrency(): string
    {
        $country = $this->getCountry();
        $currency = 'usd';
        $euroCountries = ['AT', 'BE', 'HR', 'CY', 'EE', 'FI', 'FR', 'DE', 'GR', 'IE', 'IT', 'LV', 'LT', 'LU', 'MT', 'NL', 'PT', 'SK', 'SI', 'ES', 'EZ'];

        if (in_array($country, $euroCountries)) {
            $currency = 'eur';
        }

        return $currency;
    }
}
