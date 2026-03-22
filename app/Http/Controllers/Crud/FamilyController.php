<?php

namespace App\Http\Controllers\Crud;

use App\Datagrids\Filters\FamilyFilter;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreFamily;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\Family;
use App\Models\MiscModel;
use App\Renderers\DatagridRenderer;
use App\Services\AttributeService;
use App\Services\Entity\EntitySaveService;
use App\Services\Entity\Relations\FamilyRelationsService;
use App\Services\FilterService;

class FamilyController extends CrudController
{
    protected string $view = 'families';

    protected string $route = 'families';

    protected string $module = 'families';

    protected string $model = Family::class;

    protected string $filter = FamilyFilter::class;

    public function __construct(
        FilterService $filterService,
        DatagridRenderer $datagridRenderer,
        AttributeService $attributeService,
        EntitySaveService $entitySaveService,
        protected FamilyRelationsService $familyRelationsService,
    ) {
        parent::__construct($filterService, $datagridRenderer, $attributeService, $entitySaveService);
    }

    public function store(StoreFamily $request, Campaign $campaign)
    {
        return $this->campaign($campaign)->crudStore($request);
    }

    public function show(Campaign $campaign, Family $family)
    {
        return $this->campaign($campaign)->crudShow($family);
    }

    public function edit(Campaign $campaign, Family $family)
    {
        return $this->campaign($campaign)->crudEdit($family);
    }

    public function update(StoreFamily $request, Campaign $campaign, Family $family)
    {
        return $this->campaign($campaign)->crudUpdate($request, $family);
    }

    public function destroy(Campaign $campaign, Family $family)
    {
        return $this->campaign($campaign)->crudDestroy($family);
    }

    protected function afterModelSave(MiscModel $model, array $data): void
    {
        $this->familyRelationsService->save($model, $data);
    }

    protected function getEntityType(): EntityType
    {
        return EntityType::where('id', config('entities.ids.family'))->first();
    }
}
