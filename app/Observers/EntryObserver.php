<?php

namespace App\Observers;

use App\Facades\CampaignLocalization;
use App\Jobs\EntityMappingJob;
use App\Services\Mentions\SaveService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class EntryObserver
{
    use PurifiableTrait;

    public function saving(Model $model)
    {
        // When creating modules through the API, there might be no entry, which is why we need to
        // check if they are in the attributes of the model before interacting with it;
        $attributes = $model->getAttributes();
        // @phpstan-ignore-next-line
        if (! array_key_exists($model->entryFieldName(), $attributes)) {
            return;
        }
        /** @var SaveService $service */
        $service = app()->make(SaveService::class);
        $campaign = CampaignLocalization::getCampaign();
        // When creating a campaign, there is no campaign yet
        if ($campaign) {
            $service->campaign($campaign);
        }
        // @phpstan-ignore-next-line
        $model->{$model->entryFieldName()} = $this->purify(
            $service
                ->user(auth()->user())
                // @phpstan-ignore-next-line
                ->text($model->{$model->entryFieldName()})
                ->save()
        );

        // Word count
        if (! Arr::exists($attributes, 'words')) {
            return;
        }
        // @phpstan-ignore-next-line
        $model->words = str_word_count(strip_tags($model->{$model->entryFieldName()}));
    }

    public function saved(Model $model)
    {
        // @phpstan-ignore-next-line
        if ($model->isClean([$model->entryFieldName(), $model->tooltipFieldName()])) {
            return;
        }
        if (method_exists($model, 'mentions')) {
            EntityMappingJob::dispatch($model);
        }
    }
}
