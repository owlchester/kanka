<?php

namespace App\Services\Entity;

use App\Http\Requests\MovePostRequest;
use App\Models\Post;
use App\Services\EntityMappingService;

class PostService
{
    /** @var EntityMappingService */
    protected EntityMappingService $mappingService;

    public function __construct(EntityMappingService $mappingService)
    {
        $this->mappingService = $mappingService;
    }

    /**
     * Move or copy an entity note to another entity
     *
     * @param Post $post
     * @param MovePostRequest $request
     * @return Post
     */
    public function movePost(Post $post, MovePostRequest $request): Post
    {
        if ($request->has('copy')) {
            $newPost = $post->replicate();
            $newPost->entity_id = $request->get('entity');
            $newPost->savedObserver = false;
            $newPost->save();

            // Also replicate permissions
            foreach ($post->permissions as $perm) {
                $newPerm = $perm->replicate(['post_id']);
                $newPerm->post_id = $newPost->id;
                $newPerm->save();
            }

            // Update the "mentioned in" mapping for the entity
            $this->mappingService->mapPost($newPost);

            return $newPost;
        }

        $post->entity_id = $request->get('entity');
        $post->save();


        return $post;
    }
}
