<?php

namespace Database\Factories;

use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\MiscModel;
use App\Services\Entity\StandardEntityCreationService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

/**
 * @template TModel of MiscModel
 *
 * @extends Factory<TModel>
 */
abstract class StandardEntityFactory extends Factory
{
    protected function store(Collection $results)
    {
        $results->each(function (MiscModel $model): void {
            app(StandardEntityCreationService::class)
                ->campaign(Campaign::findOrFail($model->campaign_id))
                ->entityType(EntityType::findOrFail($model->entityTypeId()))
                ->create($model->attributesToArray(), $model);

            $this->createChildren($model);
        });
    }
}
