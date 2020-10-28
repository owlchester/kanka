<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreCommunityVote;
use App\Http\Requests\StoreFaq;
use App\Models\CommunityVote;
use Illuminate\Http\Request;

class CommunityVoteController extends AdminCrudController
{
    /**
     * @var string
     */
    protected $view = 'admin.community-votes';
    protected $route = 'admin.community-votes';
    protected $trans = 'admin/community-votes';

    /**
     * @var string
     */
    protected $model = \App\Models\CommunityVote::class;

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
            ->with('ballots')
            ->filter(request()->all())
            ->search($filterService->search())
            ->orderByDesc('visible_at')
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CommunityVote $communityVote
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommunityVote $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CommunityVote $communityVote
     * @return \Illuminate\Http\Response
     */
    public function edit(CommunityVote $communityVote)
    {
        return $this->crudEdit($communityVote);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faq  $character
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCommunityVote $request, CommunityVote $communityVote)
    {
        return $this->crudUpdate($request, $communityVote, []);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CommunityVote $communityVote
     * @return \Illuminate\Http\Response
     */
    public function destroy(CommunityVote $communityVote)
    {
        //$this->authorize('unboost', $communityVote);
        $communityVote->delete();

        return redirect()->route($this->route . '.index')
            ->with('success', trans($this->trans . '.destroy.success', ['name' => $communityVote->name]));

    }
}
