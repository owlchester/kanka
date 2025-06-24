<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Http\Requests\HistoryRequest;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityLog;
use App\Models\Post;

class LogController extends Controller
{
    public function index(HistoryRequest $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity);
        $this->authorize('history', [$entity, $campaign]);

        $fields = ['action'];
        $expanded = false;
        if ($campaign->superboosted()) {
            $fields = ['q', 'action'];
            if ($request->filled('q')) {
                $expanded = true;
            }
        }

        $postIds = $entity->posts()->pluck('id');
        $logs = EntityLog::where(function ($query) use ($entity, $postIds) {
            $query->where(function ($sub) use ($entity) {
                $sub->where('parent_type', Entity::class)
                    ->where('parent_id', $entity->id);
            })
                ->orWhere(function ($sub) use ($postIds) {
                    $sub->where('parent_type', Post::class)
                        ->whereIn('parent_id', $postIds);
                });
        })
            ->filter($request->only($fields))
            ->with([
            'user',
            'impersonator',
            'parent',
        ])
            ->recent()
            ->paginate(config('limits.pagination'));

        $transKey = $entity->entityType->pluralCode();

        $q = request()->get('q');
        $action = request()->get('action');
        $actions = [
            '' => __('history.filters.all-actions'),
            EntityLog::ACTION_CREATE => __('entities/logs.actions.create'),
            EntityLog::ACTION_UPDATE => __('entities/logs.actions.update'),
            EntityLog::ACTION_DELETE => __('entities/logs.actions.delete'),
            EntityLog::ACTION_RESTORE => __('entities/logs.actions.restore'),
        ];

        return view('entities.pages.logs.index', compact(
            'campaign',
            'entity',
            'logs',
            'campaign',
            'transKey',
            'q',
            'action',
            'actions',
            'expanded',
        ));
    }
}
