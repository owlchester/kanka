<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\TagFilter;
use App\Datagrids\Sorters\TagChildrenSorter;
use App\Datagrids\Sorters\TagTagSorter;
use App\Http\Requests\StoreTagEntity;
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

    /** @var string Model */
    protected $model = \App\Models\Tag::class;

    /** @var string Filter */
    protected $filter = TagFilter::class;

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
        return $this
            ->datagridSorter(TagTagSorter::class)
            ->menuView($tag, 'tags');
    }

    /**
     * @param Tag $tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function children(Tag $tag)
    {
        return $this
            ->datagridSorter(TagChildrenSorter::class)
            ->menuView($tag, 'children');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function mapPoints(Tag $tag)
    {
        return $this->menuView($tag, 'map-points', true);
    }

    /**
     * @param Tag $tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function entityAdd(Tag $tag)
    {
        $this->authorize('update', $tag);
        $ajax = request()->ajax();
        $formOptions = ['tags.entity-add', 'tag' => $tag];
        if (request()->has('from-children')) {
            $formOptions['from-children'] = true;
        }

        return view('tags.entities.create', [
            'model' => $tag,
            'ajax' => $ajax,
            'formOptions' => $formOptions
        ]);
    }

    /**
     * @param StoreTagEntity $request
     * @param Tag $tag
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function entityStore(StoreTagEntity $request, Tag $tag)
    {
        $this->authorize('update', $tag);
        $redirectUrlOptions = ['tag' => $tag->id];
        if (request()->has('from-children')) {
            $redirectUrlOptions['tag_id'] = $tag->id;
        }

        $tag->attachEntity($request->only('entity_id'));
        return redirect()->route('tags.children', $redirectUrlOptions)
            ->with('success', trans('tags.children.create.success', ['name' => $tag->name]));
    }
}
