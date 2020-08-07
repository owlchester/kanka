<?php

namespace App\Http\Controllers\Entity;

use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Models\EntityLog;
use App\Services\Entity\LogService;

class LogController extends Controller
{
    /**
     * @var LogService
     */
    protected $logService;

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
    public function index(Entity $entity)
    {
        $this->authorize('update', $entity->child);
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('history', [$entity, $campaign]);

        $ajax = request()->ajax();

        $entity = $this->logService->createMissingLogs($entity);
        $logs = $entity->logs()->with(['user', 'impersonator'])->recent()->paginate();

        return view('entities.pages.logs.logs', compact(
            'ajax',
            'entity',
            'logs'
        ));
    }
}
