<?php

namespace App\Services\Entity;

use App\Facades\Identity;
use App\Http\Requests\MovePostRequest;
use App\Jobs\EntityMappingJob;
use App\Models\Entity;
use App\Models\EntityLog;
use App\Models\Post;
use App\Services\EntityMappingService;
use App\Traits\PostAware;
use App\Traits\UserAware;

class PostService
{
    use PostAware;
    use UserAware;

    protected EntityMappingService $mappingService;

    protected int $entityId;

    public function __construct(EntityMappingService $mappingService)
    {
        $this->mappingService = $mappingService;
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
        $newPost = $this->post->copyTo($entity, true);

        // Update the "mentioned in" mapping for the entity
        EntityMappingJob::dispatch($newPost);

        $this->log($newPost, EntityLog::ACTION_CREATE_POST);

        return $newPost;
    }

    /**
     * Move the post to another entity
     */
    protected function move(): Post
    {
        foreach ($this->post->imageMentions as $imageMention) {
            $imageMention->entity_id = $this->entityId;
            $imageMention->save();
        }
        $this->post->entity_id = $this->entityId;
        $this->post->save();

        $this->log($this->post, EntityLog::ACTION_UPDATE_POST);

        return $this->post;
    }

    private function log(Post $post, int $action)
    {
        $log = new EntityLog;
        $log->parent_id = $post->id;
        $log->parent_type = Post::class;
        $log->created_by = $this->user->id;
        $log->impersonated_by = Identity::getImpersonatorId();
        $log->action = $action;
        $log->save();
    }
}
