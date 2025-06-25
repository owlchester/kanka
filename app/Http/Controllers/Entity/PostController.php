<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePost;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\MiscModel;
use App\Models\Post;
use App\Services\MultiEditingService;
use App\Services\Posts\Permissions\SavePermissionsService;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class PostController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function __construct(
        protected SavePermissionsService $savePermissionsService,
        protected MultiEditingService $editingService,
    ) {}

    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authorize('browse', [$entity]);

        return redirect()->to($entity->url());
    }

    public function create(Campaign $campaign, Entity $entity, Post $post)
    {
        $this->authorize('post', [$entity, 'add']);
        $parentRoute = $entity->entityType->pluralCode();
        $templates = Post::postTemplates($campaign)->orderBy('name')->pluck('name', 'id')->all();

        $template = request()->input('template');
        if (! empty($template) && $this->authorize('useTemplates', $campaign)) {
            $template = Post::postTemplates($campaign)->where('posts.id', $template)->first();
        }

        return view('entities.pages.posts.create', compact(
            'campaign',
            'post',
            'entity',
            'parentRoute',
            'templates',
            'template',
        ));
    }

    public function show(Campaign $campaign, Entity $entity, Post $post)
    {
        $this->campaign($campaign)->authEntityView($entity);
        if (! request()->json()) {
            return redirect()->to($entity->url());
        }

        return view('entities.pages.posts.show')
            ->with('campaign', $campaign)
            ->with('entity', $entity)
            ->with('post', $post);
    }

    public function store(StorePost $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('post', [$entity, 'add']);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $data = $campaign->superboosted() ? $request->all() : $request->except(['layout_id']);
        $data['entity_id'] = $entity->id;
        $post = Post::create($data);

        $this->savePermissionsService->post($post)->request($request)->save();

        if ($request->has('submit-new')) {
            $route = route('entities.posts.create', [$campaign, $entity]);

            return response()->redirectTo($route);
        } elseif ($request->has('submit-update')) {
            $route = route('entities.posts.edit', [$campaign, $entity, $post]);

            return response()->redirectTo($route);
        }

        return redirect()
            ->to($entity->url())
            ->with('success', __('entities/notes.create.success', [
                'name' => $post->name, 'entity' => $entity->name,
            ]));
    }

    public function edit(Campaign $campaign, Entity $entity, Post $post)
    {
        $this->authorize('post', [$entity, 'edit', $post]);
        $editingUsers = null;

        /** @var Post $model */
        $model = $post;

        if ($campaign->hasEditingWarning()) {
            $editingUsers = $this->editingService->model($model)->user(auth()->user())->users();
            // If no one is editing the model, we are now editing it
            if (empty($editingUsers)) {
                $this->editingService->edit();
            }
        }

        $parentRoute = $entity->entityType->pluralCode();
        $from = request()->get('from');

        return view('entities.pages.posts.edit', compact(
            'campaign',
            'entity',
            'model',
            'parentRoute',
            'from',
            'editingUsers'
        ));
    }

    public function update(StorePost $request, Campaign $campaign, Entity $entity, Post $post)
    {
        $this->authorize('post', [$entity, 'edit', $post]);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $data = $request->all();
        unset($data['entity_id']);
        if ($request->isNotFilled('position')) {
            unset($data['position']);
        }
        $post->update($data);
        $this->savePermissionsService
            ->post($post)
            ->request($request)
            ->save();

        $this->editingService->model($post)
            ->user($request->user())
            ->finish();

        if ($request->has('submit-new')) {
            $route = route('entities.posts.create', [$campaign, $entity]);

            return response()->redirectTo($route);
        } elseif ($request->has('submit-update')) {
            $route = route('entities.posts.edit', [$campaign, $entity, $post]);

            return response()->redirectTo($route);
        }

        return redirect()->route('entities.show', [$campaign, $entity, '#post-' . $post->id])
            ->with('success', __('entities/notes.edit.success', [
                'name' => $post->name, 'entity' => $entity->name,
            ]));
    }

    public function destroy(Campaign $campaign, Entity $entity, Post $post)
    {
        $this->authorize('post', [$entity, 'delete']);

        $post->delete();

        return redirect()
            ->route('entities.show', [$campaign, $entity])
            ->with('success', __('entities/notes.destroy.success', [
                'name' => $post->name, 'entity' => $entity->name,
            ]));
    }
}
