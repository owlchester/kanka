<?php

namespace App\Http\Controllers\Entity;

use App\Exceptions\TranslatableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\MovePostRequest;
use App\Http\Requests\TransformEntityRequest;
use App\Models\Entity;
use App\Facades\CampaignLocalization;
use App\Models\EntityNote;
use App\Services\EntityService;
use App\Traits\GuestAuthTrait;
use Illuminate\Support\Facades\Auth;

class PostMoveController extends Controller
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
    public function index(Entity $entity, EntityNote $entity_note)
    {
        $this->authorize('view', $entity->child);
        $campaign = CampaignLocalization::getCampaign()->entities()->get();

        return view('entities.pages.move.entity_notes.index', compact(
            'entity',
            'entity_note',
            'campaign',
        ));
    }

    /**
     * @param TransformEntityRequest $request
     * @param Entity $entity
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function move(MovePostRequest $request, Entity $entity, EntityNote $entity_note)
    {
        $this->authorize('view', $entity_note);

        try {
            $this->service
                ->moveEntityNote($entity_note, $request->only('entity', 'copy'));

            $copied = $this->service->copied();

            return redirect()
                ->route($entity_note->pluralType() . '.index')
                ->with('success', __('entities/move.success' . ($copied ? '_copy' : null), ['name' => $entity->name]));
        }
        catch (TranslatableException $ex) {
            return redirect()
                ->route($entity_note->pluralType() . '.show', $entity->entity_id)
                ->with('error', __($ex->getMessage(), ['name' => $entity->name]));
        }
    }
}
