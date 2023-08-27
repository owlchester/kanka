<?php

namespace App\Http\Controllers\Crud;

use App\Datagrids\Filters\QuestFilter;
use App\Facades\Datagrid;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreQuest;
use App\Models\Campaign;
use App\Models\Quest;
use App\Traits\TreeControllerTrait;

class QuestController extends CrudController
{
    use TreeControllerTrait;

    /**
     */
    protected string $view = 'quests';
    protected string $route = 'quests';
    protected $module = 'quests';

    /** @var string Model */
    protected $model = \App\Models\Quest::class;

    /** @var string Filter */
    protected string $filter = QuestFilter::class;

    /**
     */
    public function store(StoreQuest $request, Campaign $campaign)
    {
        return $this->campaign($campaign)->crudStore($request);
    }

    /**
     */
    public function show(Campaign $campaign, Quest $quest)
    {
        return $this->campaign($campaign)->crudShow($quest);
    }

    /**
     */
    public function edit(Campaign $campaign, Quest $quest)
    {
        return $this->campaign($campaign)->crudEdit($quest);
    }

    /**
     */
    public function update(StoreQuest $request, Campaign $campaign, Quest $quest)
    {
        return $this->campaign($campaign)->crudUpdate($request, $quest);
    }

    /**
     */
    public function destroy(Campaign $campaign, Quest $quest)
    {
        return $this->campaign($campaign)->crudDestroy($quest);
    }

    public function quests(Campaign $campaign, Quest $quest)
    {
        $this->authCheck($quest);

        $options = ['campaign' => $campaign, 'quest' => $quest];
        $filters = [];
        if (request()->has('parent_id')) {
            $options['parent_id'] = $quest->id;
            $filters['quest_id'] = $quest->id;
        }

        Datagrid::layout(\App\Renderers\Layouts\Quest\Quest::class)
            ->route('quests.quests', $options);

        // @phpstan-ignore-next-line
        $this->rows = $quest
            ->descendants()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->with(['entity', 'entity.image', 'quest', 'quest.entity'])
            ->has('entity')
            ->filter($filters)
            ->paginate(15);

        //return $this->campaign($campaign)->datagridAjax();

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }
        return redirect()->to($quest->getLink());
    }
}
