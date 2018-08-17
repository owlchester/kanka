<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Http\Requests\StoreSection;
use App\Models\Section;
use App\Services\SectionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class SectionController extends CrudController
{
    /**
     * @var string
     */
    protected $view = 'sections';
    protected $route = 'sections';

    /**
     * @var string
     */
    protected $model = \App\Models\Section::class;

    /**
     * SectionController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->indexActions[] = [
            'route' => route('sections.tree'),
            'class' => 'default',
            'label' => '<i class="fa fa-tree"></i> ' . trans('sections.index.actions.explore_view')
        ];

        $this->filters = [
            'name',
            'type',
            [
                'field' => 'section_id',
                'label' => trans('crud.fields.section'),
                'type' => 'select2',
                'route' => route('sections.find'),
                'placeholder' =>  trans('crud.placeholders.section'),
                'model' => Section::class,
            ],
        ];
    }

    /**
     * Tree / Exploration mode
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tree(Request $request)
    {
        $model = new $this->model;
        $this->filterService->prepare($this->view . 'tree', request()->all(), $model->filterableColumns());
        $name = $this->view;
        $actions = $this->indexActions;
        $filters = $this->filters;
        $filterService = $this->filterService;

        $actions = [[
            'route' => route('sections.index'),
            'class' => 'default',
            'label' => '<i class="fa fa-list"></i> ' . trans('sections.index.title')
        ]];

        $search = $model
            ->acl(Auth::user())
            ->filter($this->filterService->filters())
            ->search(request()->get('search'))
            ->order($this->filterService->order());

        if (request()->has('parent_id')) {
            $search = $search->where(['section_id' => request()->get('parent_id')]);

            $parent = $model->with('section')->where('id', request()->get('parent_id'))->first();
            if (!empty($parent) && !empty($parent->section)) {
                // Go back to parent
                $actions[] = [
                    'route' => route('sections.tree', ['parent_id' => $parent->section->id]),
                    'class' => 'default',
                    'label' => '<i class="fa fa-arrow-left"></i> ' . $parent->section->name
                ];
            } else {
                // Go back to first level
                $actions[] = [
                    'route' => route('sections.tree'),
                    'class' => 'default',
                    'label' => '<i class="fa fa-arrow-left"></i> ' . trans('crud.actions.back')
                ];
            }
        } else {
            $search = $search->whereNull('section_id');
        }
        $models = $search
            ->paginate();
        return view('sections.tree', compact('models', 'name', 'model', 'actions', 'filters', 'filterService'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSection $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        return $this->crudShow($section);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Character  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        return $this->crudEdit($section);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Character  $section
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSection $request, Section $section)
    {
        return $this->crudUpdate($request, $section);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Character  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        return $this->crudDestroy($section);
    }
}
