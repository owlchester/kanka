<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReorderStories;
use App\Models\Entity;
use App\Facades\Identity;
use App\Models\EntityLog;
use App\Services\Entity\StoryService;
use App\Traits\GuestAuthTrait;

class StoryController extends Controller
{
    /**
     * Guest Auth Trait
     */
    use GuestAuthTrait;

    /** @var StoryService */
    protected $service;

    /**
     * AbilityController constructor.
     * @param StoryService $service
     */
    public function __construct(StoryService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Entity $entity)
    {
        $this->authorize('update', $entity->child);

        return view('entities.pages.story.reorder', compact(
            'entity'
        ));
    }

    /**
     */
    public function save(ReorderStories $request, Entity $entity)
    {
        $this->authorize('update', $entity->child);

        $this->service
            ->entity($entity)
            ->reorder($request);

        $log = new EntityLog();
        $log->entity_id = $entity->id;
        $log->created_by = auth()->user()->id;
        $log->impersonated_by = Identity::getImpersonatorId();
        $log->action = EntityLog::ACTION_REORDER_POST;
        $log->save();

        return redirect()
            ->to($entity->url('show'))
            ->with('success', __('entities/story.reorder.success'));
    }

    /**
     * Load more posts to display to the user (partial view)
     */
    public function more(Entity $entity)
    {
        $this->authorize('view', $entity->child);

        $posts = $entity->posts()->ordered()->paginate(15);

        return view('entities.components.posts')
            ->with('entity', $entity)
            ->with('model', $entity->child)
            ->with('pinnedPosts', $posts);
    }
}
