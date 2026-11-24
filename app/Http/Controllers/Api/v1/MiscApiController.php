<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\MiscModel;
use App\Services\Entity\EntitySaveService;
use App\Services\Entity\Relations\EntityRelationsServiceFactory;
use App\Services\Entity\StandardEntityCreationService;
use CampaignLocalization;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class MiscApiController extends ApiController
{
    public function __construct(
        protected EntitySaveService $entitySaveService,
        protected EntityRelationsServiceFactory $relationsFactory,
        protected StandardEntityCreationService $entityCreationService,
    ) {}

    /**
     * @template T of MiscModel
     *
     * @param  HasMany<T, Campaign>  $relation
     * @param  class-string<JsonResource>  $resource
     */
    protected function listModels(Campaign $campaign, HasMany $relation, string $resource, bool $loadBeforeFiltering = false): AnonymousResourceCollection
    {
        $this->authorize('access', $campaign);

        $query = $relation->getQuery();
        if ($loadBeforeFiltering) {
            $query->withApi();
        }
        $query->filter(request()->all());
        if (! $loadBeforeFiltering) {
            $query->withApi();
        }

        return $resource::collection($query
            ->lastSync(request()->get('lastSync'))
            ->orderBy($relation->getRelated()->getQualifiedKeyName())
            ->paginate());
    }

    protected function viewModel(Campaign $campaign, MiscModel $model): MiscModel
    {
        $this->authorizeModel('view', $campaign, $model);

        return $model;
    }

    protected function storeModel(FormRequest $request, Campaign $campaign, int $entityTypeId): MiscModel
    {
        $this->authorize('access', $campaign);
        $type = EntityType::findOrFail($entityTypeId);
        $this->authorize('create', [$type, $campaign]);

        $validated = $request->validated();
        $data = $this->childData($request, $validated);
        $data['campaign_id'] = $campaign->id;
        $model = $this->entityCreationService
            ->campaign($campaign)
            ->entityType($type)
            ->create($data);
        $this->crudSave($model, $validated);

        return $model;
    }

    protected function updateModel(FormRequest $request, Campaign $campaign, MiscModel $model): MiscModel
    {
        $this->authorizeModel('update', $campaign, $model);
        $validated = $request->validated();
        $model->update($this->childData($request, $validated));
        $this->crudSave($model, $validated);

        return $model;
    }

    protected function deleteModel(Campaign $campaign, MiscModel $model): JsonResponse
    {
        $this->authorizeModel('delete', $campaign, $model);
        $model->entity->delete();

        return response()->json(null, 204);
    }

    protected function childData(FormRequest $request, array $validated): array
    {
        return $validated;
    }

    private function authorizeModel(string $ability, Campaign $campaign, MiscModel $model): void
    {
        $this->authorize('access', $campaign);
        $this->authorize($ability, $model->entity);
    }

    protected function crudSave(MiscModel $model, array $data): void
    {
        $service = $this->relationsFactory->for($model->entity);
        if (request()->isMethod('patch')) {
            $service?->patch();
        }
        $service?->save($model, $data);

        if (! empty($model->entity)) {
            $campaign = CampaignLocalization::getCampaign();
            $this->entitySaveService->campaign($campaign)->entity($model->entity)->save($data);
            if ($model->wasChanged() && ! $model->entity->wasChanged()) {
                $model->entity->touch();
            }
        }
        $model->refresh();
    }
}
