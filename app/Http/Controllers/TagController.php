<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Http\Requests\StoreTag;
use App\Models\Tag;
use App\Services\TagService;
use App\Traits\TreeControllerTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class TagController extends CrudController
{
    use TreeControllerTrait;

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
    
    /**
     * @param Tag $tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function tags(Tag $tag)
    {
        return $this->menuView($tag, 'tags');
    }

    /**
     * @param Tag $tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function children(Tag $tag)
    {
        return $this->menuView($tag, 'children');
    }
}
