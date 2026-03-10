<?php

namespace App\Http\Controllers\Bulks;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\BulkService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct(
        protected BulkService $bulkService,
    ) {
        $this->middleware('auth');
    }

    public function index(Request $request, Campaign $campaign, EntityType $entityType)
    {
        $entities = $request->get('entities');

        return view('cruds.datagrids.bulks.modals._permissions')
            ->with('campaign', $campaign)
            ->with('entityType', $entityType)
            ->with('entities', $entities);
    }

    public function apply(Request $request, Campaign $campaign, EntityType $entityType)
    {
        $models = explode(',', $request->get('models'));
        if ($request->has('entities')) {
            $models = $request->get('entities');
        }

        $count = $this
            ->bulkService
            ->campaign($campaign)
            ->user($request->user())
            ->entityType($entityType)
            ->entities($models)
            ->permissions(
                request()->only('user', 'role'),
                request()->has('permission-override')
            );

        return redirect()
            ->back()
            ->with('success', trans_choice('entries/bulk.success.permissions', $count, ['count' => $count]));
    }
}
