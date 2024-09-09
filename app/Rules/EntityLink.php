<?php

namespace App\Rules;

use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\Entity;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class EntityLink implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Validate that tue url is for Kanka
        if (!Str::startsWith($value, config('app.url'))) {
            $fail(__('validation.entity_link'));
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
            $fail(__('validation.entity_link'));
        }

        if ($segments[1] !== 'campaign' || !is_numeric($segments[2])) {
            $fail(__('validation.entity_link'));
        }

        // Check that the campaign is public
        $campaign = Campaign::where('id', $segments[2])->first();
        if (empty($campaign) || !$campaign->isPublic()) {
            $fail(__('validation.entity_link'));
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
                $fail(__('validation.entity_link'));
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
            $fail(__('validation.entity_link'));
        }

        // Figuring out if the entity is visible to the public role is going to be tricky, so let's start doing some magic.
        $publicRole = $campaign->roles()->public()->first();
        if (empty($publicRole)) {
            $fail(__('validation.entity_link'));
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
        if (empty($permission)) {
            $fail(__('validation.entity_link'));
        }
    }
}
