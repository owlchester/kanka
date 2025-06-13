<?php

namespace App\Http\Controllers\Bulks;

use App\Datagrids\Actions\BookmarkDatagridActions;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\BulkService;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    public function __construct(
        protected BulkService $bulkService,
    ) {
        $this->middleware('auth');
    }

    public function index(Request $request, Campaign $campaign, EntityType $entityType)
    {
        $datagrid = null;
        if ($entityType->id === config('entities.ids.bookmark')) {
            $datagrid = new BookmarkDatagridActions;
        }
        $entities = $request->get('entities');

        return view('cruds.datagrids.bulks.modals.delete.delete')
            ->with('campaign', $campaign)
            ->with('entityType', $entityType)
            ->with('datagrid', $datagrid)
            ->with('entities', $entities);
    }

    public function apply(Request $request, Campaign $campaign, EntityType $entityType)
    {
        $models = explode(',', $request->get('models'));
        if ($request->has('entities')) {
            $models = $request->get('entities');
        }

        $count = $this->bulkService
            ->entityType($entityType)
            ->entities($models)
            ->campaign($campaign)
            ->user($request->user())
            ->delete();
        $key = 'crud.destroy_many.success';

        return redirect()
            ->back()
            ->with('success', trans_choice($key, $count, ['count' => $count]));
    }
}
