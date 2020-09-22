<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreReferral;
use App\Models\Referral;
use Illuminate\Http\Request;

class ReferralController extends AdminCrudController
{
    /**
     * @var string
     */
    protected $view = 'admin.referrals';
    protected $route = 'admin.referrals';
    protected $trans = 'admin/referrals';

    /**
     * @var string
     */
    protected $model = \App\Models\Referral::class;

    /**
     * CharacterController constructor.
     */
    public function __construct()
    {
        $this->filters = [
            'code',
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
     * @param  \App\Models\Release $release
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReferral $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Referral $referral
     * @return \Illuminate\Http\Response
     */
    public function edit(Referral $referral)
    {
        return $this->crudEdit($referral);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Referral  $referral
     * @return \Illuminate\Http\Response
     */
    public function update(StoreReferral $request, Referral $referral)
    {
        return $this->crudUpdate($request, $referral, []);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Referral $referral
     * @return \Illuminate\Http\Response
     */
    public function destroy(Referral $referral)
    {
        $referral->delete();

        return redirect()->route($this->route . '.index')
            ->with('success', trans($this->trans . '.destroy.success', ['name' => $referral->name]));

    }
}
