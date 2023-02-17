<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Entity\LogService;

class LogController extends Controller
{
    protected LogService $logService;

    /**
     * LogController constructor.
     * @param LogService $logService
     */
    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity->child);
        $this->authorize('history', [$entity, $campaign]);

        $ajax = request()->ajax();

        $logs = $entity->logs()->with(['user', 'impersonator', 'post'])->recent()->paginate();

        $transKey = $entity->pluralType();

        return view('entities.pages.logs.logs', compact(
            'campaign',
            'entity',
            'logs',
            'transKey'
        ));
    }
}
