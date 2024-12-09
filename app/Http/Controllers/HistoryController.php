<?php

namespace App\Http\Controllers;

use App\Http\Requests\HistoryRequest;
use App\Models\Campaign;
use App\Models\EntityLog;

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
        $models = EntityLog::select(['entity_logs.*'])
            ->with(['user', 'entity' => fn ($q) => $q->withTrashed(), 'impersonator', 'post'])
            ->leftJoin('entities as e', 'e.id', 'entity_logs.entity_id')
            ->filter($request->only('action', 'user'))
            ->orderBy('entity_logs.created_at', 'desc')
            ->where('e.campaign_id', '=', $campaign->id)
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
        if (!empty($user)) {
            $filters['user'] = (int) $user;
        }
        if (!empty($action)) {
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
