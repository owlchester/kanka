<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Facades\CampaignLocalization;
use App\Services\MultiEditingService;
use App\Models\EntityNote;
use App\Traits\GuestAuthTrait;
use Illuminate\Support\Facades\Auth;
use App\Models\Entity;

class EntityNoteController extends Controller
{
    use GuestAuthTrait;

    public function index(Entity $entity)
    {
        $this->authorize('browse', [$entity->child]);
        return redirect()->to($entity->url());
    }

    public function create(Entity $entity, EntityNote $entityNote)
    {
        $this->authorize('entity-note', [$entity->child, 'add']);

        $parentRoute = $entity->pluralType();

        return view('entities.pages.posts.create', compact(
            'entityNote',
            'entity',
            'parentRoute',
        ));
    }

    public function show(Entity $entity, EntityNote $entityNote)
    {
        // Policies will always fail if they can't resolve the user.
        if (Auth::check()) {
            $this->authorize('view', $entity->child);
        } else {
            if (empty($entity->child)) {
                abort(404);
            }
            $this->authorizeEntityForGuest(\App\Models\CampaignPermission::ACTION_READ, $entity->child);
        }
        return redirect()->to($entity->url());
    }

    public function store(StorePost $request, Entity $entity)
    {
        $this->authorize('entity-note', [$entity->child, 'add']);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $note = new EntityNote();
        $note->entity_id = $entity->id;
        $note = $note->create($request->all());

        if ($request->has('submit-new')) {
            $route = route('entities.entity_notes.create', [$entity]);
            return response()->redirectTo($route);
        } elseif ($request->has('submit-update')) {
            $route = route('entities.entity_notes.edit', [$entity, $note]);
            return response()->redirectTo($route);
        }

        return redirect()
            ->route($entity->pluralType() . '.show', [$entity->child->id])
            ->with('success', __('entities/notes.create.success', [
                'name' => $note->name, 'entity' => $entity->child->name
            ]));
    }

    public function edit(Entity $entity, EntityNote $entityNote)
    {
        $this->authorize('entity-note', [$entity->child, 'edit', $entityNote]);

        dd('waaaa');
        /** @var MiscModel $model */
        $editingUsers = null;
        $model = $entityNote;

        if ($campaign->hasEditingWarning()) {
            /** @var MultiEditingService $editingService */
            $editingService = app()->make(MultiEditingService::class);
            $editingUsers = $editingService->model($model)->user(auth()->user())->users();
            // If no one is editing the model, we are now editing it
            if (empty($editingUsers)) {
                $editingService->edit();
            }
        }

        $parentRoute = $entity->pluralType();
        $from = request()->get('from');

        return view('entities.pages.posts.edit', compact(
            'campaign',
            'entity',
            'model',
            'parentRoute',
            'from',
            'editingUsers',
        ));
    }

    public function update(StorePost $request, Entity $entity, EntityNote $entityNote)
    {
        $this->authorize('entity-note', [$entity->child, 'edit', $entityNote]);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $entityNote->update($request->all());

        /** @var MultiEditingService $editingService */
        $editingService = app()->make(MultiEditingService::class);
        $editingService->model($entityNote)
            ->user($request->user())
            ->finish();


        if ($request->has('submit-new')) {
            $route = route('entities.entity_notes.create', [$entity]);
            return response()->redirectTo($route);
        } elseif ($request->has('submit-update')) {
            $route = route('entities.entity_notes.edit', [$entity, $entityNote]);
            return response()->redirectTo($route);
        }

        return redirect()->route($entity->pluralType() . '.show', [$entity->child->id, '#post-' . $entityNote->id])
            ->with('success', __('entities/notes.edit.success', [
                'name' => $entityNote->name, 'entity' => $entity->name
            ]));
    }

    public function destroy(Entity $entity, EntityNote $entityNote)
    {
        $this->authorize('entity-note', [$entity->child, 'delete']);

        $entityNote->delete();

        return redirect()
            ->route($entity->pluralType() . '.show', [$entity->child->id])
            ->with('success', __('entities/notes.destroy.success', [
                'name' => $entityNote->name, 'entity' => $entity->name
            ]));
    }
}
