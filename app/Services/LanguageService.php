<?php

namespace App\Services;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LanguageService
{
    /**
     * @return array
     */
    public function getSupportedLanguagesList()
    {
        $languages = [];
        foreach (LaravelLocalization::getSupportedLocales() as $langKey => $langData) {
            $languages[$langKey] = trans('languages.codes.' . $langKey);
        }
        return $languages;
    }
}
