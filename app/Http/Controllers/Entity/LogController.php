<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Models\EntityLog;

class LogController extends Controller
{
    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Entity $entity)
    {
        $this->authorize('update', $entity->child);

        $ajax = request()->ajax();
        $logs = $entity->logs()->recent()->paginate(3);

        return view('entities.pages.logs.logs', compact(
            'ajax',
            'entity',
            'logs'
        ));
    }
}