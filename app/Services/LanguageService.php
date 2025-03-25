<?php

namespace App\Services;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LanguageService
{
    /**
     * @return array
     */
    public function getSupportedLanguagesList($emptyOption = false)
    {
        $languages = [];
        if ($emptyOption) {
            $languages = [null => ''];
        }
        foreach (LaravelLocalization::getSupportedLocales() as $langKey => $langData) {
            $languages[$langKey] = trans('languages.codes.' . $langKey);
        }

        return $languages;
    }
}
