<?php

namespace App\Http\Controllers;

use App\Http\Requests\HistoryRequest;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityLog;
use App\Models\Post;

class HistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(HistoryRequest $request, Campaign $campaign)
    {
        $this->authorize('recover', $campaign);

        $pagnation = $campaign->superboosted() ? 25 : 10;
        $models = EntityLog::where(function ($query) use ($campaign) {
            $query->where(function ($sub) use ($campaign) {
                $sub->where('parent_type', Entity::class)
                    ->whereIn('parent_id', function ($entities) use ($campaign) {
                        $entities
                            ->select('id')
                            ->from('entities')
                            ->where('entities.campaign_id', $campaign->id);
                    });
            })->orWhere(function ($query) use ($campaign) {
                $query->where('parent_type', Post::class)
                    ->whereIn('parent_id', function ($subquery) use ($campaign) {
                        $subquery->select('posts.id')
                            ->from('posts')
                            ->join('entities', 'entities.id', '=', 'posts.entity_id')
                            ->where('entities.campaign_id', $campaign->id);
                    });
            });
            })
            ->with([
                'user',
                'impersonator',
                'parent' => function ($morphTo) {
                    $morphTo->withTrashed()->morphWith([
                        Entity::class => ['entityType'],
                        Post::class => ['entity' =>  fn ($q) => $q->withTrashed(), 'entity.entityType'],
                    ]);
                },
            ])
            ->filter($request->only('action', 'user'))
            ->orderBy('entity_logs.created_at', 'desc')
            //->where('parent.campaign_id', '=', $campaign->id)
            ->paginate($pagnation);

        $previous = null;
        $superboosted = $campaign->superboosted();

        $users = $campaign
            ->members()
            ->leftJoin('users as u', 'u.id', 'campaign_user.user_id')
            ->with(['user'])
            ->orderBy('u.name')
            ->get();
        $user = $request->get('user');
        $action = $request->get('action');
        $actions = [
            '' => __('history.filters.all-actions'),
            EntityLog::ACTION_CREATE => __('entities/logs.actions.create'),
            EntityLog::ACTION_UPDATE => __('entities/logs.actions.update'),
            EntityLog::ACTION_DELETE => __('entities/logs.actions.delete'),
            EntityLog::ACTION_RESTORE => __('entities/logs.actions.restore'),
        ];

        $filters = [];
        if (! empty($user)) {
            $filters['user'] = (int) $user;
        }
        if (! empty($action)) {
            $filters['action'] = (int) $action;
        }

        return view('history.index', compact(
            'models',
            'previous',
            'campaign',
            'superboosted',
            'users',
            'user',
            'action',
            'actions',
            'filters',
        ));
    }
}
