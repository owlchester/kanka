<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\TagFilter;
use App\Facades\Datagrid;
use App\Http\Requests\StoreTagEntity;
use App\Http\Requests\StoreTag;
use App\Http\Requests\TransferTag;
use App\Models\Tag;
use App\Services\TagService;
use App\Exceptions\TranslatableException;
use App\Traits\TreeControllerTrait;

class TagController extends CrudController
{
    use TreeControllerTrait;

    /**
     * @var string
     */
    protected string $view = 'tags';
    protected string $route = 'tags';
    protected $module = 'tags';

    /** @var string Model */
    protected $model = \App\Models\Tag::class;

    /** @var string Filter */
    protected $filter = TagFilter::class;

    protected TagService $service;

    /**
     * Constructor
     * @param TagService $service
     */
    public function __construct(TagService $service)
    {
        parent::__construct();
        $this->hasLimitCheck(false);
        $this->service = $service;

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTag $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        return $this->crudShow($tag);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        return $this->crudEdit($tag);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTag $request, Tag $tag)
    {
        return $this->crudUpdate($request, $tag);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        return $this->crudDestroy($tag);
    }

    /**
     * @param Tag $tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function tags(Tag $tag)
    {
        $this->authCheck($tag);

        $options = ['tag' => $tag];
        $filters = [];
        if (request()->has('tag_id')) {
            $options['tag_id'] = $tag->id;
            $filters['tag_id'] = $tag->id;
        }
        Datagrid::layout(\App\Renderers\Layouts\Tag\Tag::class)
            ->route('tags.tags', $options);

        // @phpstan-ignore-next-line
        $this->rows = $tag
            ->descendants()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->filter($filters)
            ->with(['entity', 'entity.tags', 'entity.image', 'tag', 'tag.entity'])
            ->paginate();

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->datagridAjax();
        }
        return $this
            ->menuView($tag, 'tags');
    }

    /**
     * @param Tag $tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function children(Tag $tag)
    {
        $this->authCheck($tag);

        $options = ['tag' => $tag];
        $base = 'allChildren';
        if (request()->has('tag_id')) {
            $options['tag_id'] = $tag->id;
            $base = 'entities';
        }
        Datagrid::layout(\App\Renderers\Layouts\Tag\Entity::class)
            ->route('tags.children', $options);

        $this->rows = $tag
            ->{$base}()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->with(['image', 'tags'])
            ->paginate(15);

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->datagridAjax();
        }

        return $this
            ->menuView($tag, 'children');
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
        $formOptions = ['tags.entity-add.save', 'tag' => $tag];
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
        return redirect()->route('tags.show', $redirectUrlOptions)
            ->with('success', trans('tags.children.create.success', ['name' => $tag->name]));
    }

    /**
     * @param Tag $tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function transferTag(Tag $tag)
    {
        $this->authorize('update', $tag);

        return view('tags.transfer', compact('tag'));
    }

    /**
     * @param TransferTag $request
     * @param Tag $tag
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function transfer(TransferTag $request, Tag $tag)
    {
        $newTag = Tag::where('id', $request->tag_id)->first();
        $this->authorize('update', $tag);
        try {
            $this->service->transfer($tag, $newTag);
            return redirect()
                ->route('tags.show', $tag)
                ->with('success_raw', __('tags.transfer.success', ['tag' => $tag->name, 'newTag' => $newTag->name]));
        } catch (TranslatableException $ex) {
            return redirect()
                ->route('tags.show', $tag)
                ->with('error', __('tags.transfer.fail', ['tag' => $tag->name, 'newTag' => $newTag->name]));
        }
    }
}
