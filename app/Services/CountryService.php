<?php

namespace App\Services;

class CountryService
{
    /**
     * @return string
     */
    public function getCountry()
    {
        $country = 'CH';
        if (isset($_SERVER["HTTP_CF_IPCOUNTRY"])) {
            $country = mb_substr($_SERVER["HTTP_CF_IPCOUNTRY"], 0, 6);
        }
        return $country;
    }


    /**
     * @return string
     */
    public function getCurrency()
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
