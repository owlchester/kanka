<?php

namespace App\Http\Controllers\Bulks;

use App\Datagrids\Bulks\Bulk;
use App\Datagrids\Bulks\EntityBulk;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\BulkService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BatchController extends Controller
{
    public function __construct(
        protected BulkService $bulkService,
    ) {
        $this->middleware('auth');
    }

    public function index(Request $request, Campaign $campaign, EntityType $entityType)
    {
        $entities = $request->get('entities');

        return view('cruds.datagrids.bulks.modals._batch')
            ->with('campaign', $campaign)
            ->with('bulk', $this->resolveBulk($entityType))
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
            ->entityType($entityType)
            ->user($request->user())
            ->campaign($campaign)
            ->entities($models)
            ->editing($request->all(), $this->resolveBulk($entityType));

        $total = $this->bulkService->total();

        $key = 'editing';
        if ($count != $total) {
            $key = 'editing_partial';
        }

        return redirect()
            ->back()
            ->with('success', trans_choice('entries/bulk.success.' . $key, $count, ['count' => $count, 'total' => $total]));
    }

    private function resolveBulk(EntityType $entityType): Bulk
    {
        $bulkClass = 'App\Datagrids\Bulks\\' . Str::studly($entityType->code) . 'Bulk';

        if (class_exists($bulkClass)) {
            return new $bulkClass;
        }

        return new EntityBulk;
    }
}
