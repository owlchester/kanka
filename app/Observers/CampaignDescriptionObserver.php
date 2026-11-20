<?php

namespace App\Observers;

use App\Jobs\EntityMappingJob;
use App\Models\CampaignDescription;
use App\Services\Mentions\SaveService;

class CampaignDescriptionObserver
{
    use PurifiableTrait;

    public function __construct(protected SaveService $saveService) {}

    public function saving(CampaignDescription $description): void
    {
        $attributes = $description->getAttributes();
        $campaign = $description->campaign;

        foreach (['description', 'excerpt'] as $field) {
            if (! array_key_exists($field, $attributes)) {
                continue;
            }
            $service = $this->saveService->campaign($campaign);
            $service = auth()->check()
                ? $service->user(auth()->user())
                : $service->userless();

            $description->$field = $this->purify(
                $service->text($description->$field)->save()
            );
        }
    }

    public function saved(CampaignDescription $description): void
    {
        if ($description->isClean('description')) {
            return;
        }

        $campaign = $description->campaign;
        if ($campaign && method_exists($campaign, 'mentions')) {
            EntityMappingJob::dispatch($campaign);
        }
    }
}
