<?php

namespace App\Http\Controllers\Bulks;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransformEntityRequest;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\BulkService;
use App\Services\Entity\TypeService;
use App\Services\EntityTypeService;

class TransformController extends Controller
{
    public function __construct(
        protected BulkService $bulkService,
        protected EntityTypeService $entityTypeService,
        protected TypeService $typeService,
    ) {
        $this->middleware('auth');
    }

    public function index(Campaign $campaign, EntityType $entityType)
    {
        $entities = $this->entityTypeService
            ->campaign($campaign)
            ->exclude([$entityType->id, config('entities.ids.bookmark')])
            ->prepend(['' => __('entities/transform.fields.select_one')])
            ->toSelect();

        return view('cruds.datagrids.bulks.modals._transform')
            ->with('campaign', $campaign)
            ->with('entities', $entities)
            ->with('entityType', $entityType)
        ;
    }

    public function apply(TransformEntityRequest $request, Campaign $campaign, EntityType $entityType)
    {
        $models = explode(',', request()->get('models'));

        $newEntityType = EntityType::inCampaign($campaign)->find($request->get('target'));

        $count = $this
            ->bulkService
            ->entities($models)
            ->entityType($entityType)
            ->campaign($campaign)
            ->transform($newEntityType);

        return redirect()
            ->back()
            ->with('success_raw', trans_choice('entities/transform.bulk.success', $count, ['count' => $count, 'type' => $newEntityType->plural()]));
    }
}
