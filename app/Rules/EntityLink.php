<?php

namespace App\Rules;

use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\Entity;
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
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
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
        // 0: lang
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
        if (empty($campaign) || !$campaign->isPublic()) {
            return false;
        }

        // Are we targeting an entity or a misc?
        $entity = null;
        if ($segments[3] === 'entities') {
            /** @var ?Entity $entity */
            // @phpstan-ignore-next-line
            $entity = Entity::where('id', (int) $segments[4])
                ->where('campaign_id', $campaign->id)
                ->allCampaigns()
                ->withInvisible()
                ->first();
        } else {
            $entityTypeID = config('entities.ids.' . Str::singular($segments[3]));
            if (empty($entityTypeID)) {
                return false;
            }
            // @phpstan-ignore-next-line
            $entity = Entity::where('entity_id', (int) $segments[4])
                ->allCampaigns()
                ->withInvisible()
                ->where('type_id', $entityTypeID)
                ->where('campaign_id', $campaign->id)
                ->first();
        }
        if (empty($entity) || $entity->is_private) {
            return false;
        }

        // Figuring out if the entity is visible to the public role is going to be tricky, so let's start doing some magic.
        $publicRole = $campaign->roles()->public()->first();
        if (empty($publicRole)) {
            return false;
        }

        $permission = $publicRole->permissions()

            ->where(function ($sub) use ($entity) {
                return $sub->where('entity_id', $entity->id)
                    ->orWhere('entity_type_id', $entity->typeId());
            })
            ->where('access', 1)
            ->where('action', CampaignPermission::ACTION_READ)
            ->first();

        // We don't check for the public role have deny as a permission, this is good enough
        return !empty($permission);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.entity_link');
    }
}
