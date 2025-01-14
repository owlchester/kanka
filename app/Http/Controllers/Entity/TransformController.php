<?php

namespace App\Http\Controllers\Entity;

use App\Exceptions\TranslatableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransformEntityRequest;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityType;
use App\Services\Entity\TransformService;
use App\Services\Entity\TypeService;
use App\Services\EntityService;
use App\Services\EntityTypeService;
use App\Traits\GuestAuthTrait;

class TransformController extends Controller
{
    use GuestAuthTrait;

    public function __construct(
        protected EntityService $service,
        protected EntityTypeService $entityTypeService,
        protected TransformService $transformService,
        protected TypeService $typeService)
    {
    }

    public function index(Campaign $campaign, Entity $entity)
    {
        // Policies will always fail if they can't resolve the user.
        $this->authorize('move', $entity);

        $entities = $this->entityTypeService
            ->campaign($campaign)
            ->exclude([$entity->entityType->id, config('entities.ids.bookmark')])
            ->prepend(['' => __('entities/transform.fields.select_one')])
            ->toSelect();

        return view('entities.pages.transform.index', compact(
            'campaign',
            'entity',
            'entities',
            'campaign',
        ));
    }

    public function transform(TransformEntityRequest $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('move', $entity);
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        try {
            $entityType = EntityType::inCampaign($campaign)->find($request->get('target'));
            $this->transformService
                ->campaign($campaign)
                ->entity($entity)
                ->entityType($entityType)
                ->transform();

            return redirect()
                ->to($entity->url())
                ->with('success', __('entities/transform.success', ['name' => $entity->name]));
        } catch (TranslatableException $ex) {
            return redirect()
                ->route('entities.show', [$campaign, $entity])
                ->with('error', __($ex->getMessage(), ['name' => $entity->name]));
        }
    }
}
