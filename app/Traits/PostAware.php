<?php

namespace App\Traits;

use App\Models\Post;

trait PostAware
{
    public Post $post;

    public function post(Post $post): self
    {
        $this->post = $post;

        return $this;
    }
}
