<?php

namespace App\Http\Controllers\Bulks;

use App\Datagrids\Actions\BookmarkDatagridActions;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\BulkService;

class DeleteController extends Controller
{
    public function __construct(
        protected BulkService $bulkService,
    ) {
        $this->middleware('auth');
    }

    public function index(Campaign $campaign, EntityType $entityType)
    {
        $datagrid = null;
        if ($entityType->id === config('entities.ids.bookmark')) {
            $datagrid = new BookmarkDatagridActions();
        }

        return view('cruds.datagrids.bulks.modals.delete.delete')
            ->with('campaign', $campaign)
            ->with('entityType', $entityType)
            ->with('datagrid', $datagrid)
        ;
    }

    public function apply(Campaign $campaign, EntityType $entityType)
    {
        $models = explode(',', request()->get('models'));

        $count = $this->bulkService
            ->entityType($entityType)
            ->entities($models)
            ->campaign($campaign)
            ->delete();
        $key = 'crud.destroy_many.success';

        return redirect()
            ->back()
            ->with('success', trans_choice($key, $count, ['count' => $count]));
    }
}
