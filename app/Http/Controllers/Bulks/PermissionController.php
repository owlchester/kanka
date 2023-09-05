<?php

namespace App\Http\Controllers\Bulks;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\BulkService;

class PermissionController extends Controller
{
    protected BulkService $bulkService;

    public function __construct(
        BulkService $bulkService,
    ) {
        $this->bulkService = $bulkService;

        $this->middleware('auth');
        $this->middleware('campaign.member');
    }

    public function index(Campaign $campaign, EntityType $entityType)
    {

        return view('cruds.datagrids.bulks.modals._permissions')
            ->with('campaign', $campaign)
            ->with('entityType', $entityType)
        ;
    }

    public function apply(Campaign $campaign, EntityType $entityType)
    {
        $models = explode(',', request()->get('models'));

        $count = $this
            ->bulkService
            ->entity($entityType->code)
            ->entities($models)
            ->permissions(
                request()->only('user', 'role'),
                request()->has('permission-override')
            );

        return redirect()
            ->back()
            ->with('success', trans_choice('crud.bulk.success.permissions', $count, ['count' => $count]));
    }
}
