<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReorderStories;
use App\Models\Ability;
use App\Models\Entity;
use App\Models\EntityAbility;
use App\Services\Entity\StoryService;
use App\Traits\GuestAuthTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    /**
     * Guest Auth Trait
     */
    use GuestAuthTrait;

    /** @var StoryService */
    protected $service;

    /**
     * AbilityController constructor.
     * @param StoryService $service
     */
    public function __construct(StoryService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Entity $entity)
    {
        $this->authorize('update', $entity->child);

        return view('entities.pages.story.reorder', compact(
            'entity'
        ));
    }

    /**
     * @param Request $request
     * @param Model $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(ReorderStories $request, Entity $entity)
    {
        $this->authorize('update', $entity->child);

        $this->service
            ->entity($entity)
            ->reorder($request);

        return redirect()
            ->to($entity->url('show'))
            ->with('success', __('entities/story.reorder.success'));
    }

    public function more(Entity $entity)
    {
        $this->authorize('view', $entity->child);

        $notes = $entity->notes()->ordered()->paginate(15);

        return view('entities.components.notes')
            ->with('entity', $entity)
            ->with('model', $entity->child)
            ->with('pinnedNotes', $notes);

    }

}
