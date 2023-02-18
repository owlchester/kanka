<?php

namespace App\Http\Controllers\Entity;

use App\Exceptions\TranslatableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\MoveEntityRequest;
use App\Models\Campaign;
use App\Models\Entity;
use App\Facades\CampaignLocalization;
use App\Services\EntityService;
use App\Traits\GuestAuthTrait;
use Illuminate\Support\Facades\Auth;

class MoveController extends Controller
{
    use GuestAuthTrait;

    protected EntityService $service;

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
    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authorize('view', $entity->child);

        $campaigns = [0 => __('entities/move.fields.select_one')];
        foreach (auth()->user()->campaigns()->whereNot('campaign_id', $campaign->id)->get() as $camp) {
            $campaigns[$camp->id] = $camp->name;
        }

        return view('entities.pages.move.index', compact(
            'campaign',
            'entity',
            'campaigns'
        ));
    }

    /**
     * @param MoveEntityRequest $request
     * @param Entity $entity
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function move(MoveEntityRequest $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('view', $entity->child);

        try {
            $this->service
                ->campaign($campaign)
                ->move($entity, $request->only('campaign', 'copy'));

            $copied = $this->service->copied();

            return redirect()
                ->route($entity->url('index'))
                ->with('success', __('entities/move.success' . ($copied ? '_copy' : null), ['name' => $entity->name]));
        } catch (TranslatableException $ex) {
            return redirect()
                ->route($entity->pluralType() . '.show', $entity->entity_id)
                ->with('error', __($ex->getMessage(), ['name' => $entity->name]));
        }
    }
}
