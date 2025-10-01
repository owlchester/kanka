<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Entity\ArchiveService;

class ArchiveController extends Controller
{
    protected ArchiveService $service;

    public function __construct(ArchiveService $archiveService)
    {
        $this->middleware('auth');
        $this->service = $archiveService;
    }

    public function update(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity);

        if (request()->ajax()) {
            return response()->json();
        }

        $this->service->entity($entity)->toggle();

        return redirect()->back()
            ->with(
                'success',
                __('entities/actions.' . ($entity->archived_at ? 'archive' : 'unarchive') . '.success', ['name' => $entity->name])
            );
    }
}
