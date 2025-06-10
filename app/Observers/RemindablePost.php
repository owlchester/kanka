<?php

namespace App\Observers;

use App\Models\Post;
use App\Services\Entity\RemindableService;

class RemindablePost
{
    protected RemindableService $service;

    public function __construct(RemindableService $service)
    {
        $this->service = $service;
    }

    public function saved(Post $post)
    {
        $this->service->processSaved($post);
    }
}
