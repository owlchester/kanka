<?php

namespace App\Rules;

use App\Models\Campaign;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class EntityLink implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Validate that tue url is for Kanka
        if (!Str::startsWith($value, config('app.url'))) {
            return false;
        }

        // Extract the campaign and entity
        $value = Str::after($value, config('app.url'));
        $value = trim($value, '/');

        $segments = explode('/', $value);
        // 0: land
        // 1: campaign
        // 2: campaign id
        // 3: character|entities
        // 4: id
        if (count($segments) < 3) {
            return false;
        }

        if ($segments[1] !== 'campaign' || !is_numeric($segments[2])) {
            return false;
        }

        // Check that the campaign is public
        $campaign = Campaign::where('id', $segments[2])->first();
        if (empty($campaign) || $campaign->is_private) {
            return false;
        }

        // We've checked the obvious stuff, so let's assume this is valid for now.
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.entity_link');
    }
}
