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
    protected EntityNoteService $service;

    /**
     * AbilityController constructor.
     * @param EntityNoteService $service
     */
    public function __construct(EntityNoteService $service)
    {
        $this->service = $service;
    }

    /**
     */
    public function index(Entity $entity, EntityNote $entityNote)
    {
        $this->authorize('view', $entity->child);
        $campaign = CampaignLocalization::getCampaign()->entities()->get();

        return view('entities.pages.posts.move.index', compact(
            'entity',
            'entityNote',
            'campaign',
        ));
    }

    /**
     */
    public function move(MovePostRequest $request, Entity $entity, EntityNote $entityNote)
    {
        $this->authorize('update', $entity->child);
        /** @var Entity|null $newEntity */
        $newEntity = Entity::where(['id' => $request['entity']])->first();
        $this->authorize('update', $newEntity->child);
        try {
            $newNote = $this->service
                ->moveEntityNote($entityNote, $request);
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
