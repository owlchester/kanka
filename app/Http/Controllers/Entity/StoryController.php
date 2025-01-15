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
    use GuestAuthTrait;

    protected StoryService $service;

    public function __construct(StoryService $service)
    {
        $this->service = $service;
    }

    public function edit(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity);

        return view('entities.pages.story.reorder', compact(
            'campaign',
            'entity'
        ));
    }

    public function save(ReorderStories $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity);
        if ($request->ajax()) {
            return response()->json();
        }

        $this->service
            ->entity($entity)
            ->reorder($request);

        return redirect()
            ->to($entity->url())
            ->with('success', __('entities/story.reorder.success'));
    }

    /**
     * Load more posts to display to the user (partial view)
     */
    public function more(Campaign $campaign, Entity $entity)
    {
        $this->authorize('view', $entity->child);

        $pagination = app()->isProduction() ? 15 : 6;
        $posts = $entity->posts()->with(['permissions', 'location', 'layout'])->ordered()->paginate($pagination);

        return view('entities.components.posts')
            ->with('entity', $entity)
            ->with('model', $entity->child)
            ->with('more', true)
            ->with('campaign', $campaign)
            ->with('posts', $posts);
    }
}
