<?php

namespace App\Http\Controllers\Bulks;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\BulkService;
use App\Services\Entity\TypeService;

class TransformController extends Controller
{
    protected BulkService $bulkService;
    protected TypeService $typeService;

    public function __construct(
        BulkService $bulkService,
        TypeService $typeService,
    ) {
        $this->bulkService = $bulkService;
        $this->typeService = $typeService;

        $this->middleware('auth');
        $this->middleware('campaign.member');
    }

    public function index(Campaign $campaign, EntityType $entityType)
    {
        $entities = $this->typeService
            ->exclude([$entityType->code, 'bookmark', 'relation'])
            ->withNull()
            ->labelled();
        $entities[''] = __('entities/transform.fields.select_one');

        return view('cruds.datagrids.bulks.modals._transform')
            ->with('campaign', $campaign)
            ->with('entities', $entities)
            ->with('entityType', $entityType)
        ;
    }

    public function apply(Campaign $campaign, EntityType $entityType)
    {
        $models = explode(',', request()->get('models'));
        $target = request()->get('target');

        $count = $this
            ->bulkService
            ->entity($entityType->code)
            ->entities($models)
            ->transform($target);

        return redirect()
            ->back()
            ->with('success_raw', trans_choice('entities/transform.bulk.success', $count, ['count' => $count, 'type' => __('entities.' . $target)]));
    }
}
