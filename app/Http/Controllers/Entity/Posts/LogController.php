<?php

namespace App\Http\Controllers\Entity\Posts;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Post;

class LogController extends Controller
{
    public function index(Campaign $campaign, Entity $entity, Post $post)
    {
        $this->authorize('history', [$entity, $campaign]);
        $this->authorize('post', [$entity->child, 'edit', $post]);

        $logs = $entity
            ->logs()
            ->where('post_id', $post->id)
            ->with(['user', 'impersonator', 'post'])
            ->recent()
            ->paginate();

        $transKey = $entity->pluralType();

        return view('entities.pages.logs.logs', compact(
            'post',
            'campaign',
            'entity',
            'logs',
            'campaign',
            'transKey'
        ));
    }
}
