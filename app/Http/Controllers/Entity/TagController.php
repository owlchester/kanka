<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateEntityTags;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Entity\TagService;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class TagController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    protected TagService $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity);
        $formOptions = ['entity.tags-add.save', $campaign, 'entity' => $entity];

        return view('entities.components.tags.create', [
            'campaign' => $campaign,
            'entity' => $entity,
            'formOptions' => $formOptions,
        ]);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(UpdateEntityTags $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity);
        if ($request->ajax()) {
            return response()->json();
        }

        $ids = request()->post('tags', []);
        if (empty($ids)) {
            $ids = [];
        }
        $this->tagService
            ->user($request->user())
            ->entity($entity)
            ->withNew()
            ->sync($ids);
        $entity->touch();

        return redirect()->route('entities.show', [$campaign, $entity])
            ->with('success', __('tags.children.create.attach_success_entity', ['name' => $entity->name]));
    }
}
