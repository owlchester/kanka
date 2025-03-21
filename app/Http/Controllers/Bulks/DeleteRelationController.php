<?php

namespace App\Http\Controllers\Bulks;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\BulkService;

class DeleteRelationController extends Controller
{
    public function __construct(
        protected BulkService $bulkService,
    ) {
        $this->middleware('auth');
    }

    public function index(Campaign $campaign)
    {
        $datagrid = new \App\Datagrids\Actions\RelationDatagridActions;

        return view('cruds.datagrids.bulks.modals.delete.relation')
            ->with('campaign', $campaign)
            ->with('datagrid', $datagrid);
    }

    public function apply(Campaign $campaign)
    {
        $models = explode(',', request()->get('models'));

        $count = $this->bulkService
            ->entities($models)
            ->campaign($campaign)
            ->delete();
        $key = 'entities/relations.bulk.delete';

        return redirect()
            ->back()
            ->with('success', trans_choice($key, $count, ['count' => $count]));
    }
}
