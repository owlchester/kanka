<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReorderStories;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Entity\StoryService;
use App\Traits\GuestAuthTrait;

class StoryController extends Controller
{
    /**
     * Guest Auth Trait
     */
    use GuestAuthTrait;

    protected StoryService $service;

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
    public function edit(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity->child);
        $model = $entity->child;
        return view('entities.pages.story.reorder', compact(
            'campaign',
            'model',
            'entity'
        ));
    }

    /**
     */
    public function save(ReorderStories $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity->child);

        $this->service
            ->entity($entity)
            ->reorder($request);

        return redirect()
            ->to($entity->url('show'))
            ->with('success', __('entities/story.reorder.success'));
    }

    /**
     * Load more posts to display to the user (partial view)
     */
    public function more(Campaign $campaign, Entity $entity)
    {
        $this->authorize('view', $entity->child);

        $posts = $entity->posts()->ordered()->paginate(15);

        return view('entities.components.posts')
            ->with('campaign', $campaign)
            ->with('entity', $entity)
            ->with('model', $entity->child)
            ->with('pinnedPosts', $posts);
    }
}
