<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\QuestFilter;
use App\Facades\Datagrid;
use App\Http\Requests\StoreQuest;
use App\Models\Quest;
use App\Traits\TreeControllerTrait;

class QuestController extends CrudController
{
    use TreeControllerTrait;

    /**
     * @var string
     */
    protected string $view = 'quests';
    protected string $route = 'quests';
    protected $module = 'quests';

    /** @var string Model */
    protected $model = \App\Models\Quest::class;

    /** @var string Filter */
    protected $filter = QuestFilter::class;

    /**
     */
    public function store(StoreQuest $request)
    {
        return $this->crudStore($request);
    }

    /**
     */
    public function show(Quest $quest)
    {
        return $this->crudShow($quest);
    }

    /**
     */
    public function edit(Quest $quest)
    {
        return $this->crudEdit($quest);
    }

    /**
     */
    public function update(StoreQuest $request, Quest $quest)
    {
        return $this->crudUpdate($request, $quest);
    }

    /**
     */
    public function destroy(Quest $quest)
    {
        return $this->crudDestroy($quest);
    }

    /**
     */
    public function quests(Quest $quest)
    {
        $this->authCheck($quest);

        $options = ['quest' => $quest];
        $filters = [];
        if (request()->has('parent_id')) {
            $options['parent_id'] = $quest->id;
            $filters['quest_id'] = $quest->id;
        }

        Datagrid::layout(\App\Renderers\Layouts\Quest\Quest::class)
            ->route('quests.quests', $options);

        //dd($quest->quests()->get(), $quest->descendants()->get());
        $this->rows = $quest
            ->descendants()
            ->sort(request()->only(['o', 'k']))
            ->with(['entity', 'entity.image', 'quest', 'quest.entity'])
            ->has('entity')
            ->filter($filters)
            ->paginate(15);

        //return $this->datagridAjax();

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->datagridAjax();
        }
        return $this
            ->menuView($quest, 'quests', show: true);
    }
}
