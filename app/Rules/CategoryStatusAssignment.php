<?php

namespace App\Rules;

use App\Models\Campaign;
use App\Models\CategoryStatus;
use App\Models\Entity;
use App\Models\EntityType;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class CategoryStatusAssignment implements ValidationRule
{
    public function __construct(private ?Campaign $campaign = null, private ?EntityType $category = null, private ?Entity $entity = null) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $entity = $this->entity ?? request()->route('entity');
        $campaign = $this->campaign ?? request()->route('campaign');
        $category = $this->category ?? ($entity instanceof Entity ? $entity->entityType : (request()->route('entity_type') ?? request()->route('entityType')));
        if (! $category instanceof EntityType) {
            $route = request()->route()?->getName() ?? '';
            foreach (config('entities.ids') as $code => $id) {
                if (str_contains($route, Str::plural($code) . '.')) {
                    $category = EntityType::find($id);
                    break;
                }
            }
        }

        if (! $campaign instanceof Campaign || ! $category instanceof EntityType) {
            $fail(__('The selected status is invalid.'));

            return;
        }

        $status = CategoryStatus::inCampaign($campaign)->where('category_id', $category->id)->find($value);
        if (! $status || ($category->isCustom() && ($category->campaign_id !== $campaign->id || $status->campaign_id !== $campaign->id))) {
            $fail(__('The selected status is invalid.'));
        } elseif ($status->isCustom() && ! $campaign->premium() && (! $entity instanceof Entity || (int) $entity->status_id !== (int) $value)) {
            $fail(__('New status assignments require a premium campaign.'));
        }
    }
}
