<?php

namespace App\Http\Controllers\Entity;

use App\Exceptions\TranslatableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\MovePostRequest;
use App\Http\Requests\TransformEntityRequest;
use App\Models\Entity;
use App\Facades\CampaignLocalization;
use App\Models\EntityNote;
use App\Services\EntityNoteService;
use Illuminate\Support\Facades\Auth;

class PostMoveController extends Controller
{
    /** @var EntityNoteService */
    protected $service;

    /**
     * AbilityController constructor.
     * @param EntityNoteService $service
     */
    public function __construct(EntityNoteService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Entity $entity, EntityNote $entityNote)
    {
        $this->authorize('view', $entity->child);
        $campaign = CampaignLocalization::getCampaign()->entities()->get();

        return view('entities.pages.entity-notes.move.index', compact(
            'entity',
            'entityNote',
            'campaign',
        ));
    }

    /**
     * @param TransformEntityRequest $request
     * @param Entity $entity
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function move(MovePostRequest $request, Entity $entity, EntityNote $entityNote)
    {

        $newEntity = Entity::where(['id' => $request['entity']])->first();
        $this->authorize('update', $newEntity->child);
        try {
            $newNote = $this->service
                ->moveEntityNote($entityNote, $request->only('entity', 'copy'));
            $success = 'move_success';
            if (isset($request['copy'])) {
                $success = 'copy_success';
            }
            return redirect()
                ->route($newEntity->pluralType() . '.show', [$newEntity->child->id, '#post-' . $newNote->id])
                ->with('success', __('entities/notes.move.' . $success, ['name' => $newNote->name,
                'entity' => $newEntity->name
            ]));
        } catch (TranslatableException $ex) {
            return redirect()
                ->route($entity->pluralType() . '.show', [$entity->child->id, '#post-' . $entityNote->id])
                ->with('error', __($ex->getMessage(), ['name' => $entity->name]));
        }
    }
}
