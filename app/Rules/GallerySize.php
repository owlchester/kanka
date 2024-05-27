<?php

namespace App\Rules;

use App\Facades\CampaignLocalization;
use App\Services\Campaign\GalleryService;
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
        /** @var GalleryService $service */
        $service = app()->make(GalleryService::class);
        $available = $service->campaign(CampaignLocalization::getCampaign())->available();

        try {
            $size = (int)floor($value->getSize() / 1024);
            if ($size > $available) {
                $available = $service->human($available);
                $fail(__('campaigns/gallery.errors.storage', ['available' => $available]));
            }
        } catch (Exception $e) {
            $available = $service->human($available);
            $fail(__('campaigns/gallery.errors.storage', ['available' => $available]));
        }
    }
}
