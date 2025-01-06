<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class EntityFile implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Not a valid file, don't go further
        if ($value instanceof UploadedFile && !$value->isValid()) {
            $fail(__('validation.mimes', ['values' => 'jpg, jpeg, png, gif, webp, pdf, xls(x), csv, mp3, ogg, json']));
        }

        // Block any hacking shenanigans
        if ($this->shouldBlockPhpUpload($value, [])) {
            $fail(__('validation.mimes', ['values' => 'jpg, jpeg, png, gif, webp, pdf, xls(x), csv, mp3, ogg, json']));
        }

        if (empty($value->getPath())) {
            $fail(__('validation.mimes', ['values' => 'jpg, jpeg, png, gif, webp, pdf, xls(x), csv, mp3, ogg, json']));
        }

        $validExtensions = explode(',', 'jpeg,png,jpg,gif,webp,pdf,xls,xlsx,mp3');
        if (!in_array($value->guessExtension(), $validExtensions)) {
            $fail(__('validation.mimes', ['values' => 'jpg, jpeg, png, gif, webp, pdf, xls(x), csv, mp3, ogg, json']));
        }

        // It wasn't an image, maybe it's an audio file
        if (empty($value->getClientOriginalExtension())) {
            $fail(__('validation.mimes', ['values' => 'jpg, jpeg, png, gif, webp, pdf, xls(x), csv, mp3, ogg, json']));
        }

        if (in_array($value->getClientOriginalExtension(), ['mp3', 'ogg', 'json', 'csv'])) {
            $fail(__('validation.mimes', ['values' => 'jpg, jpeg, png, gif, webp, pdf, xls(x), csv, mp3, ogg, json']));
        }
    }

    protected function shouldBlockPhpUpload($value, $parameters)
    {
        if (in_array('php', $parameters)) {
            return false;
        }

        $phpExtensions = [
            'php', 'php3', 'php4', 'php5', 'phtml',
        ];

        return ($value instanceof UploadedFile)
            ? in_array(mb_trim(mb_strtolower($value->getClientOriginalExtension())), $phpExtensions)
            : in_array(mb_trim(mb_strtolower($value->getExtension())), $phpExtensions);
    }
}
