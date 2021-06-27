<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreFaqCategory;
use App\Models\FaqCategory;
use App\Models\FaqCategoryEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FaqCategoryController extends AdminCrudController
{
    /**
     * @var string
     */
    protected $view = 'admin.faq-categories';
    protected $route = 'admin.faq-categories';
    protected $trans = 'admin/faqs.categories';

    /**
     * @var string
     */
    protected $model = \App\Models\FaqCategory::class;

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
            ->with('faqs')
            ->search($filterService->search())
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
     * @param FaqCategory $faqCategory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(FaqCategory $faqCategory)
    {
        return redirect()
            ->route('admin.faq-categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FaqCategory $faqCategory
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFaqCategory $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FaqCategory $faqCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(FaqCategory $faqCategory)
    {
        return $this->crudEdit($faqCategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faq  $character
     * @return \Illuminate\Http\Response
     */
    public function update(StoreFaqCategory $request, FaqCategory $faqCategory)
    {
        return $this->crudUpdate($request, $faqCategory, []);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  FaqCategory $faqCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(FaqCategory $faqCategory)
    {
        //$this->authorize('unboost', $faqCategory);
        $faqCategory->delete();

        return redirect()->route($this->route . '.index')
            ->with('success', trans($this->trans . '.destroy.success', ['name' => $faqCategory->name]));

    }
}
