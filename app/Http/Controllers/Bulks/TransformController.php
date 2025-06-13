<?php

namespace App\Http\Controllers\Bulks;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransformEntityRequest;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\BulkService;
use App\Services\EntityTypeService;
use Illuminate\Http\Request;

class TransformController extends Controller
{
    public function __construct(
        protected BulkService $bulkService,
        protected EntityTypeService $entityTypeService,
    ) {
        $this->middleware('auth');
    }

    public function index(Request $request, Campaign $campaign, EntityType $entityType)
    {
        $entityTypes = $this->entityTypeService
            ->campaign($campaign)
            ->exclude([$entityType->id, config('entities.ids.bookmark')])
            ->prepend(['' => __('entities/transform.fields.select_one')])
            ->toSelect();
        $entities = $request->get('entities');

        return view('cruds.datagrids.bulks.modals._transform')
            ->with('campaign', $campaign)
            ->with('entityTypes', $entityTypes)
            ->with('entities', $entities)
            ->with('entityType', $entityType);
    }

    public function apply(TransformEntityRequest $request, Campaign $campaign, EntityType $entityType)
    {
        $models = explode(',', $request->get('models'));
        if ($request->has('entities')) {
            $models = $request->get('entities');
        }

        /** @var EntityType $newEntityType */
        $newEntityType = EntityType::inCampaign($campaign)->find($request->get('target'));

        $count = $this
            ->bulkService
            ->entities($models)
            ->entityType($entityType)
            ->campaign($campaign)
            ->transform($newEntityType);

        $link = '<a href="' . ($newEntityType->isCustom() ? route('entities.index', [$campaign, $newEntityType]) : route($newEntityType->pluralCode() . '.index', [$campaign])) . '">' . $newEntityType->name() . '</a>';

        return redirect()
            ->back()
            ->with('success_raw', trans_choice('entities/transform.bulk.success', $count, ['count' => $count, 'type' => $link]));
    }
}
