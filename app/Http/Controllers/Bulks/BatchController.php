<?php

namespace App\Http\Controllers\Bulks;

use App\Datagrids\Bulks\EntityBulk;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\BulkService;
use Illuminate\Http\Request;

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
            ->with('bulk', new EntityBulk)
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
            ->campaign($campaign)
            ->entities($models)
            ->editing($request->all(), new EntityBulk);

        $total = $this->bulkService->total();

        $key = 'editing';
        if ($count != $total) {
            $key = 'editing_partial';
        }

        return redirect()
            ->back()
            ->with('success', trans_choice('crud.bulk.success.' . $key, $count, ['count' => $count, 'total' => $total]));
    }
}
