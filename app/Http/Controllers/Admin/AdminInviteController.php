<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreReferral;
use App\Models\AdminInvite;
use App\Models\Referral;
use App\Services\TroubleshootingService;
use Illuminate\Http\Request;

class AdminInviteController extends AdminCrudController
{
    /**
     * @var string
     */
    protected $view = 'admin.admin-invites';
    protected $route = 'admin.admin_invites';
    protected $trans = 'admin/admin-invites';

    /**
     * @var string
     */
    protected $model = \App\Models\AdminInvite::class;

    /** @var TroubleshootingService */
    protected $service;

    /**
     * CharacterController constructor.
     */
    public function __construct(TroubleshootingService $service)
    {
        $this->filters = [
            'token',
        ];

        $this->service = $service;

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
        $createAction = false;
        $this->filterService->make($this->view, request()->all(), $model);
        $filterService = $this->filterService;

        $models = $model
            ->with(['user', 'campaign'])
            ->orderBy('id', 'desc')
            ->paginate();

        return view('admin.cruds.index', compact(
            'models',
            'name',
            'model',
            'actions',
            'createAction',
            'route',
            'filterService',
            'trans',
        ));
    }

    /**
     * @param AdminInvite $adminInvite
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(AdminInvite $adminInvite)
    {
        $this->service
            ->user(auth()->user())
            ->join($adminInvite);

        return redirect()
            ->route('admin.admin_invites.index')
            ->with('success_raw', 'Added yourself to the ' . $adminInvite->campaign->name . ' campaign.');
    }
}
