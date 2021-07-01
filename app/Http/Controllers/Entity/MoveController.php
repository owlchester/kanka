<?php

namespace App\Http\Controllers\Entity;

use App\Exceptions\TranslatableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\MoveEntityRequest;
use App\Http\Requests\TransformEntityRequest;
use App\Models\Entity;
use App\Services\EntityService;
use App\Traits\GuestAuthTrait;
use Illuminate\Support\Facades\Auth;

class MoveController extends Controller
{
    /**
     * Guest Auth Trait
     */
    use GuestAuthTrait;

    /** @var EntityService */
    protected $service;

    /**
     * AbilityController constructor.
     * @param EntityService $service
     */
    public function __construct(EntityService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Entity $entity)
    {
        $this->authorize('view', $entity->child);

        $campaigns = Auth::user()->moveCampaignList();
        $campaigns[0] = __('entities/move.fields.select_one');

        return view('entities.pages.move.index', compact(
            'entity',
            'campaigns'
        ));
    }

    /**
     * @param TransformEntityRequest $request
     * @param Entity $entity
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function move(MoveEntityRequest $request, Entity $entity)
    {
        $this->authorize('view', $entity->child);

        try {
            $this->service
                ->move($entity, $request->only('campaign', 'copy'));

            $copied = $this->service->copied();

            return redirect()
                ->route($entity->pluralType() . '.index')
                ->with('success', __('entities/move.success' . ($copied ? '_copy' : null), ['name' => $entity->name]));
        }
        catch (TranslatableException $ex) {
            return redirect()
                ->route($entity->pluralType() . '.show', $entity->entity_id)
                ->with('error', __($ex->getMessage(), ['name' => $entity->name]));
        }
    }
}
