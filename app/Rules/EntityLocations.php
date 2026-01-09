<?php

namespace App\Rules;

use App\Facades\CampaignLocalization;
use App\Models\EntityType;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EntityLocations implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        /** @var EntityType $module */
        $module = EntityType::find(config('entities.ids.location'));

        if (! is_array($value)) {
            $value = [$value];
        }
        foreach ($value as $id) {
            if (is_numeric($id)) {
                if (\App\Models\Location::find($id)) {
                    return;
                }
                $fail(__('crud.dynamic.unknown', ['module' => $module->name()]));
            }

            if (empty(mb_trim($id))) {
                return;
            }

            $campaign = CampaignLocalization::getCampaign();
            if (! auth()->user()->can('create', [$module, $campaign])) {
                $fail(__('crud.dynamic.permission', ['module' => $module->name()]));
            }
        }
    }
}
