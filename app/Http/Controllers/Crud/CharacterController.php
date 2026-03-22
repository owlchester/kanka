<?php

namespace App\Http\Controllers\Crud;

use App\Datagrids\Filters\CharacterFilter;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreCharacter;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\EntityType;
use App\Models\MiscModel;
use App\Renderers\DatagridRenderer;
use App\Services\AttributeService;
use App\Services\Entity\EntitySaveService;
use App\Services\Entity\Relations\CharacterRelationsService;
use App\Services\FilterService;

class CharacterController extends CrudController
{
    protected string $view = 'characters';

    protected string $route = 'characters';

    protected string $module = 'characters';

    protected string $model = Character::class;

    protected string $filter = CharacterFilter::class;

    public function __construct(
        FilterService $filterService,
        DatagridRenderer $datagridRenderer,
        AttributeService $attributeService,
        EntitySaveService $entitySaveService,
        protected CharacterRelationsService $characterRelationsService,
    ) {
        parent::__construct($filterService, $datagridRenderer, $attributeService, $entitySaveService);
    }

    public function store(StoreCharacter $request, Campaign $campaign)
    {
        return $this->campaign($campaign)->crudStore($request);
    }

    public function show(Campaign $campaign, Character $character)
    {
        return $this->campaign($campaign)->crudShow($character);
    }

    public function edit(Campaign $campaign, Character $character)
    {
        return $this->campaign($campaign)->crudEdit($character);
    }

    public function update(StoreCharacter $request, Campaign $campaign, Character $character)
    {
        return $this->campaign($campaign)->crudUpdate($request, $character);
    }

    public function destroy(Campaign $campaign, Character $character)
    {
        return $this->campaign($campaign)->crudDestroy($character);
    }

    protected function afterModelSave(MiscModel $model, array $data): void
    {
        $this->characterRelationsService->save($model, $data);
    }

    protected function getEntityType(): EntityType
    {
        return EntityType::where('id', config('entities.ids.character'))->first();
    }
}
