<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Http\Requests\StoreTag;
use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class TagController extends CrudController
{
    /**
     * @var string
     */
    protected $view = 'tags';
    protected $route = 'tags';

    /**
     * @var string
     */
    protected $model = \App\Models\Tag::class;

    /**
     * TagController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->indexActions[] = [
            'route' => route('tags.tree'),
            'class' => 'default',
            'label' => '<i class="fa fa-tree"></i> ' . trans('tags.index.actions.explore_view')
        ];

        $this->filters = [
            'name',
            'type',
            [
                'field' => 'tag_id',
                'label' => trans('crud.fields.tag'),
                'type' => 'select2',
                'route' => route('tags.find'),
                'placeholder' =>  trans('crud.placeholders.tag'),
                'model' => Tag::class,
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
            'route' => route('tags.index'),
            'class' => 'default',
            'label' => '<i class="fa fa-list"></i> ' . trans('tags.index.title')
        ]];

        $search = $model
            ->acl(Auth::user())
            ->filter($this->filterService->filters())
            ->search(request()->get('search'))
            ->order($this->filterService->order());

        if (request()->has('parent_id')) {
            $search = $search->where(['tag_id' => request()->get('parent_id')]);

            $parent = $model->with('tag')->where('id', request()->get('parent_id'))->first();
            if (!empty($parent) && !empty($parent->tag)) {
                // Go back to parent
                $actions[] = [
                    'route' => route('tags.tree', ['parent_id' => $parent->tag->id]),
                    'class' => 'default',
                    'label' => '<i class="fa fa-arrow-left"></i> ' . $parent->tag->name
                ];
            } else {
                // Go back to first level
                $actions[] = [
                    'route' => route('tags.tree'),
                    'class' => 'default',
                    'label' => '<i class="fa fa-arrow-left"></i> ' . trans('crud.actions.back')
                ];
            }
        } else {
            $search = $search->whereNull('tag_id');
        }
        $models = $search
            ->paginate();
        return view('tags.tree', compact('models', 'name', 'model', 'actions', 'filters', 'filterService'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTag $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        return $this->crudShow($tag);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Character  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return $this->crudEdit($tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Character  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTag $request, Tag $tag)
    {
        return $this->crudUpdate($request, $tag);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Character  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        return $this->crudDestroy($tag);
    }
}
