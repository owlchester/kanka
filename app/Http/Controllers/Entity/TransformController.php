<?php

namespace App\Http\Controllers\Entity;

use App\Exceptions\TranslatableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransformEntityRequest;
use App\Models\Entity;
use App\Services\EntityService;
use App\Traits\GuestAuthTrait;

class TransformController extends Controller
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
        // Policies will always fail if they can't resolve the user.
        $this->authorize('move', $entity->child);

        $entities = $this->service
            ->labelledEntities(true, [$entity->pluralType(), 'menu_links', 'relations'], true);

        $entities[''] = __('entities/transform.fields.select_one');


        return view('entities.pages.transform.index', compact(
            'entity',
            'entities'
        ));
    }

    /**
     * @param TransformEntityRequest $request
     * @param Entity $entity
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function transform(TransformEntityRequest $request, Entity $entity)
    {
        $this->authorize('move', $entity->child);

        try {
            $this->service
                ->transform($entity, $request->get('target'));

            return redirect()
                ->to($entity->url())
                ->with('success', __('entities/transform.success', ['name' => $entity->name]));
        }
        catch (TranslatableException $ex) {
            return redirect()
                ->route($entity->pluralType() . '.show', $entity->entity_id)
                ->with('error', __($ex->getMessage(), ['name' => $entity->name]));
        }
    }
}
