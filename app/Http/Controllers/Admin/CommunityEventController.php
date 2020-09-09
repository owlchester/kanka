<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreCommunityEvent;
use App\Models\CommunityEvent;
use App\Models\CommunityEventEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CommunityEventController extends AdminCrudController
{
    /**
     * @var string
     */
    protected $view = 'admin.community-events';
    protected $route = 'admin.community-events';
    protected $trans = 'admin/community-events';

    /**
     * @var string
     */
    protected $model = \App\Models\CommunityEvent::class;

    /**
     * CharacterController constructor.
     */
    public function __construct()
    {
        $this->filters = [
            'name',
        ];

        parent::__construct();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     * @throws \Exception
     */
    public function index(\Illuminate\Http\Request $request)
    {
        $model = new $this->model;
        $name = $this->view;
        $actions = $this->indexActions;
        $route = $this->route;
        $trans = $this->trans;
        $createAction = $this->createAction;
        $this->filterService->make($this->view, request()->all(), $model);
        $filterService = $this->filterService;

        $models = $model
            ->with('entries')
            ->search($filterService->search())
            ->orderByDesc('end_at')
            ->paginate();
        return view('admin.cruds.index', compact(
            'models',
            'name',
            'model',
            'actions',
            'createAction',
            'route',
            'filterService',
            'trans'
        ));
    }



    /**
     * @param CommunityEvent $communityEvent
     * @return \Illuminate\View\View
     */
    public function show(CommunityEvent $communityEvent)
    {
        return view('admin.community-events.show', ['event' => $communityEvent, 'entries' => $communityEvent->entries()->orderBy('rank', 'DESC')->with('user', 'user.apps')->paginate(50)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CommunityEvent $communityEvent
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommunityEvent $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CommunityEvent $communityEvent
     * @return \Illuminate\Http\Response
     */
    public function edit(CommunityEvent $communityEvent)
    {
        return $this->crudEdit($communityEvent);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faq  $character
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCommunityEvent $request, CommunityEvent $communityEvent)
    {
        return $this->crudUpdate($request, $communityEvent, []);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CommunityEvent $communityEvent
     * @return \Illuminate\Http\Response
     */
    public function destroy(CommunityEvent $communityEvent)
    {
        //$this->authorize('unboost', $communityEvent);
        $communityEvent->delete();

        return redirect()->route($this->route . '.index')
            ->with('success', trans($this->trans . '.destroy.success', ['name' => $communityEvent->name]));

    }

    public function rank(Request $request, CommunityEventEntry $communityEventEntry)
    {
        //$communityEventEntry = CommunityEventEntry::firstOrFail($request->get('entry'));
        $communityEventEntry->rank = $request->post('rank');
        $communityEventEntry->save();

        return redirect()->route($this->route . '.show', $communityEventEntry->event)
            ->with('success', 'Rank set.');
    }
}
