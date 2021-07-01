<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreFaq;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends AdminCrudController
{
    /**
     * @var string
     */
    protected $view = 'admin.faqs';
    protected $route = 'admin.faqs';
    protected $trans = 'admin/faqs';

    /**
     * @var string
     */
    protected $model = \App\Models\Faq::class;

    /**
     * CharacterController constructor.
     */
    public function __construct()
    {
        $this->filters = [
            'question',
            'locale',
            'order',
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
            ->search(request()->get('search'))
            ->filter($this->filterService->filters())
            ->orderBy('faq_category_id')
            ->orderBy('order')
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
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFaq $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit(Faq $faq)
    {
        return $this->crudEdit($faq);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faq  $character
     * @return \Illuminate\Http\Response
     */
    public function update(StoreFaq $request, Faq $faq)
    {
        return $this->crudUpdate($request, $faq);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Faq $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faq $faq)
    {
        return $this->crudDestroy($faq);
    }
}
