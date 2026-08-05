<?php

namespace App\Http\Controllers\Crud;

use App\Datagrids\Filters\QuestFilter;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreQuest;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\MiscModel;
use App\Models\Quest;
use App\Renderers\DatagridRenderer;
use App\Services\AttributeService;
use App\Services\Entity\EntitySaveService;
use App\Services\Entity\Relations\QuestRelationsService;
use App\Services\FilterService;

class QuestController extends CrudController
{
    protected string $view = 'quests';

    protected string $route = 'quests';

    protected string $module = 'quests';

    protected string $model = Quest::class;

    protected string $filter = QuestFilter::class;

    public function __construct(
        FilterService $filterService,
        DatagridRenderer $datagridRenderer,
        AttributeService $attributeService,
        EntitySaveService $entitySaveService,
        protected QuestRelationsService $questRelationsService,
    ) {
        parent::__construct($filterService, $datagridRenderer, $attributeService, $entitySaveService);
    }

    public function store(StoreQuest $request, Campaign $campaign)
    {
        return $this->campaign($campaign)->crudStore($request);
    }

    public function show(Campaign $campaign, Quest $quest)
    {
        return $this->campaign($campaign)->crudShow($quest);
    }

    public function edit(Campaign $campaign, Quest $quest)
    {
        return $this->campaign($campaign)->crudEdit($quest);
    }

    public function update(StoreQuest $request, Campaign $campaign, Quest $quest)
    {
        return $this->campaign($campaign)->crudUpdate($request, $quest);
    }

    public function destroy(Campaign $campaign, Quest $quest)
    {
        return $this->campaign($campaign)->crudDestroy($quest);
    }

    protected function afterModelSave(MiscModel $model, array $data): void
    {
        $this->questRelationsService->save($model, $data);
    }

    protected function getEntityType(): EntityType
    {
        return EntityType::where('id', config('entities.ids.quest'))->first();
    }
}
