<?php

namespace App\Http\Controllers\Bulks;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\BulkService;

class DeleteRelationController extends Controller
{
    protected BulkService $bulkService;

    public function __construct(
        BulkService $bulkService,
    ) {
        $this->bulkService = $bulkService;
        $this->middleware('auth');
        $this->middleware('campaign.member');
    }
    public function index(Campaign $campaign)
    {
        $datagrid = new \App\Datagrids\Actions\RelationDatagridActions();

        return view('cruds.datagrids.bulks.modals.delete.relation')
            ->with('campaign', $campaign)
            ->with('datagrid', $datagrid)
        ;
    }

    public function apply(Campaign $campaign)
    {
        $models = explode(',', request()->get('models'));

        $count = $this->bulkService
            ->entity('relations')
            ->entities($models)
            ->campaign($campaign)
            ->delete();
        $key = 'entities/relations.bulk.delete';

        return redirect()
            ->back()
            ->with('success', trans_choice($key, $count, ['count' => $count]));
    }
}
