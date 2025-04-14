<?php

namespace App\Http\Controllers\Entity\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditPostVisibility;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Post;

class VisibilityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Entity $entity, Post $post)
    {
        $this->authorize('post', [$entity, 'edit', $post]);

        return view('entities.pages.posts.dialogs.visibility', [
            'campaign' => $campaign,
            'post' => $post,
            'entity' => $entity,
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(EditPostVisibility $request, Campaign $campaign, Entity $entity, Post $post)
    {
        $this->authorize('post', [$entity, 'edit', $post]);

        $post->update($request->all());

        return response()->json(['toast' => __('visibilities.toast'), 'icon' => $post->visibilityIcon('btn-box-tool'), 'post_id' => $post->id, 'visibility_id' => $post->visibility_id]);
    }
}
