<?php

namespace App\Services\Posts;

use App\Models\Post;
use Exception;

class PurgeService
{
    /** @var int Number of total deleted posts */
    protected int $count = 0;

    public function count(): int
    {
        return $this->count;
    }

    /**
     * @throws Exception
     */
    public function trash(Post $post): void
    {
        $post->forceDelete();
        $this->count++;
    }
}
