<?php

namespace App\Http\Controllers\Entity;

use App\Exceptions\TranslatableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransformEntityRequest;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Entity\TransformService;
use App\Services\Entity\TypeService;
use App\Services\EntityService;
use App\Traits\GuestAuthTrait;

class TransformController extends Controller
{
    use GuestAuthTrait;

    protected EntityService $service;
    protected TransformService $transformService;
    protected TypeService $typeService;

    public function __construct(EntityService $service, TransformService $transformService, TypeService $typeService)
    {
        $this->service = $service;
        $this->transformService = $transformService;
        $this->typeService = $typeService;
    }

    public function index(Campaign $campaign, Entity $entity)
    {
        // Policies will always fail if they can't resolve the user.
        $this->authorize('move', $entity);

        $entities = $this->typeService
            ->campaign($campaign)
            ->exclude([$entity->entityType->code, 'bookmark', 'relation'])
            ->add(['' => __('entities/transform.fields.select_one')])
            ->get();


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
            $this->transformService
                ->entity($entity)
                ->transform($request->get('target'));

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
