<?php

namespace App\Services\Entity;

use App\Http\Requests\MovePostRequest;
use App\Models\Entity;
use App\Models\Post;
use App\Services\EntityMappingService;

class PostService
{
    protected EntityMappingService $mappingService;

    protected Post $post;

    protected int $entityId;

    public function __construct(EntityMappingService $mappingService)
    {
        $this->mappingService = $mappingService;
    }

    public function post(Post $post): self
    {
        $this->post = $post;
        return $this;
    }

    /**
     * Move or copy a post to another entity
     */
    public function handle(MovePostRequest $request): Post
    {
        $this->entityId = (int) $request->get('entity');
        if ($request->has('copy')) {
            return $this->copy();
        }
        return $this->move();
    }

    /**
     * Copy the post with its permissions to another entity
     */
    protected function copy(): Post
    {
        $entity = Entity::findOrFail($this->entityId);
        /** @var Post $newPost */
        $newPost = $this->post->copyTo($entity);

        // Update the "mentioned in" mapping for the entity
        $this->mappingService->mapPost($newPost);

        return $newPost;
    }

    /**
     * Move the post to another entity
     *
     */
    protected function move(): Post
    {
        foreach ($this->post->imageMentions as $imageMention) {
            $imageMention->entity_id = $this->entityId;
            $imageMention->save();
        }
        $this->post->entity_id = $this->entityId;
        $this->post->save();

        return $this->post;
    }
}
