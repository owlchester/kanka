<?php

namespace App\Rules;

use App\Facades\CampaignLocalization;
use App\Services\Gallery\StorageService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Exception;

class GallerySize implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        /** @var StorageService $service */
        $service = app()->make(StorageService::class);
        $available = $service->campaign(CampaignLocalization::getCampaign())->available();

        try {
            $size = (int)floor($value->getSize() / 1024);
            if ($size > $available) {
                $available = $this->human($available);
                $fail(__('campaigns/gallery.errors.storage', ['available' => $available]));
            }
        } catch (Exception $e) {
            $available = $this->human($available);
            $fail(__('campaigns/gallery.errors.storage', ['available' => $available]));
        }
    }

    public function human(int $value): string
    {
        if ($value > 1000000) {
            return floor($value / (1024 * 1024)) . ' GB';
        } elseif ($value > 1000) {
            return floor($value / 1024) . ' MB';
        }
        return $value . ' KB';
    }
}
