<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StorePatron;
use App\Http\Requests\StoreFaq;
use App\Models\Faq;
use App\Services\CampaignBoostService;
use App\User;
use Illuminate\Http\Request;
use TCG\Voyager\Models\Role;

class PatronController extends AdminCrudController
{
    /**
     * @var string
     */
    protected $view = 'admin.patrons';
    protected $route = 'admin.patrons';
    protected $trans = 'admin/patrons';

    /**
     * @var string
     */
    protected $model = \App\User::class;

    public $createAction = false;

    /** @var CampaignBoostService */
    protected $boostService;

    /**
     * CharacterController constructor.
     */
    public function __construct(CampaignBoostService $boostService)
    {
        $this->boostService = $boostService;

        $this->filters = [
            'question',
            'locale',
            'order',
        ];

        $this->indexActions = [
          [
              'params' => ['patreon_pledge' => '!!'],
              'icon' => 'fab fa-patreon',
              'text' => 'No-pledge set',
          ]
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
            ->patron()
            ->with(['boosts', 'boosts.campaign'])
            ->filter(request()->all())
            ->search($filterService->search())
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
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(StorePatron $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return $this->crudEdit($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faq  $character
     * @return \Illuminate\Http\Response
     */
    public function update(StorePatron $request, User $user)
    {
        return $this->crudUpdate($request, $user, ['patreon_pledge']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //$this->authorize('unboost', $user);

        $user->patreon_pledge = null;
        $user->patreon_email = null;
        $user->patreon_fullname = null;
        $user->save();

        foreach ($user->boosts()->with('campaign')->get() as $boost) {
            $this->boostService->campaign($boost->campaign)->unboost($boost);
        }

        /** @var Role $role */
        $role = Role::where('name', 'patreon')->first();
        $user->roles()->detach($role->id);

        return redirect()->route($this->route . '.index')
            ->with('success', trans($this->trans . '.destroy.success', ['name' => $user->name]));

    }
}
