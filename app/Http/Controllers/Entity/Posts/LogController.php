<?php

namespace App\Http\Controllers\Entity\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\HistoryRequest;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityLog;
use App\Models\Post;

class LogController extends Controller
{
    public function index(HistoryRequest $request, Campaign $campaign, Entity $entity, Post $post)
    {
        $this->authorize('history', [$entity, $campaign]);
        $this->authorize('post', [$entity, 'edit', $post]);

        $fields = ['action'];
        $expanded = false;
        if ($campaign->superboosted()) {
            $fields = ['q', 'action'];
            if ($request->filled('q')) {
                $expanded = true;
            }
        }

        $logs = $entity
            ->logs()
            ->where('post_id', $post->id)
            ->filter($request->only($fields))
            ->with(['user', 'impersonator', 'post'])
            ->recent()
            ->paginate(config('limits.pagination'));

        $transKey = $entity->pluralType();

        $q = request()->get('q');
        $action = request()->get('action');
        $actions = [
            '' => __('history.filters.all-actions'),
            EntityLog::ACTION_CREATE => __('entities/logs.actions.create'),
            EntityLog::ACTION_UPDATE => __('entities/logs.actions.update'),
            EntityLog::ACTION_DELETE => __('entities/logs.actions.delete'),
        ];

        return view('entities.pages.logs.index', compact(
            'post',
            'campaign',
            'entity',
            'logs',
            'campaign',
            'transKey',
            'q',
            'action',
            'actions',
            'expanded'
        ));
    }
}
