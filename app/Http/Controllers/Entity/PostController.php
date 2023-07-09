<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePost;
use App\Facades\CampaignLocalization;
use App\Models\MiscModel;
use App\Services\MultiEditingService;
use App\Models\Post;
use App\Traits\GuestAuthTrait;
use Illuminate\Support\Facades\Auth;
use App\Models\Entity;

class PostController extends Controller
{
    use GuestAuthTrait;

    public function index(Entity $entity)
    {
        $this->authorize('browse', [$entity->child]);
        return redirect()->to($entity->url());
    }

    public function create(Entity $entity, Post $post)
    {
        $this->authorize('post', [$entity->child, 'add']);
        $parentRoute = $entity->pluralType();

        return view('entities.pages.posts.create', compact(
            'post',
            'entity',
            'parentRoute',
        ));
    }

    public function show(Entity $entity, Post $post)
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
        $this->authorize('post', [$entity->child, 'add']);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $note = new Post();
        $note->entity_id = $entity->id;
        $note = $note->create($request->all());

        if ($request->has('submit-new')) {
            $route = route('entities.posts.create', [$entity]);
            return response()->redirectTo($route);
        } elseif ($request->has('submit-update')) {
            $route = route('entities.posts.edit', [$entity, $note]);
            return response()->redirectTo($route);
        }

        return redirect()
            ->route($entity->pluralType() . '.show', [$entity->child->id])
            ->with('success', __('entities/notes.create.success', [
                'name' => $note->name, 'entity' => $entity->child->name
            ]));
    }

    public function edit(Entity $entity, Post $post)
    {
        $this->authorize('post', [$entity->child, 'edit', $post]);

        $campaign = CampaignLocalization::getCampaign();
        $editingUsers = null;
        /** @var MiscModel $model */
        $model = $post;

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
            'entity',
            'model',
            'parentRoute',
            'from',
            'editingUsers'
        ));
    }

    public function update(StorePost $request, Entity $entity, Post $post)
    {
        $this->authorize('post', [$entity->child, 'edit', $post]);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        if ($request->isNotFilled('position')) {
            $post->update($request->except('position'));
        } else {
            $post->update($request->all());
        }

        /** @var MultiEditingService $editingService */
        $editingService = app()->make(MultiEditingService::class);
        $editingService->model($post)
            ->user($request->user())
            ->finish();


        if ($request->has('submit-new')) {
            $route = route('entities.posts.create', [$entity]);
            return response()->redirectTo($route);
        } elseif ($request->has('submit-update')) {
            $route = route('entities.posts.edit', [$entity, $post]);
            return response()->redirectTo($route);
        }

        return redirect()->route($entity->pluralType() . '.show', [$entity->child->id, '#post-' . $post->id])
            ->with('success', __('entities/notes.edit.success', [
                'name' => $post->name, 'entity' => $entity->name
            ]));
    }

    public function destroy(Entity $entity, Post $post)
    {
        $this->authorize('post', [$entity->child, 'delete']);

        $post->delete();

        return redirect()
            ->route($entity->pluralType() . '.show', [$entity->child->id])
            ->with('success', __('entities/notes.destroy.success', [
                'name' => $post->name, 'entity' => $entity->name
            ]));
    }
}
