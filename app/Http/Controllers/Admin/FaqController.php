<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreFaq;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends AdminCrudController
{
    /**
     * @var string
     */
    protected $view = 'admin.faqs';
    protected $route = 'admin.faqs';

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
        /** @var Faq $model */
        $model = new $this->model;
        $this->filterService->make($this->view, request()->all(), $model);
        $name = $this->view;
        $actions = $this->indexActions;
        $filters = $this->filters;
        $filterService = $this->filterService;
        $route = $this->route;

        $models = $model
            ->search(request()->get('search'))
            ->filter($this->filterService->filters())
            ->order($this->filterService->order(), 'question')
            ->paginate();
        return view('admin.cruds.index', compact(
            'models',
            'name',
            'model',
            'actions',
            'filters',
            'filterService',
            'route'
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
