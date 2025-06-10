<?php

namespace App\Http\Controllers\Entity;

use App\Exceptions\TranslatableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\MoveEntityRequest;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Entity\MoveService;
use App\Services\EntityTypeService;
use App\Services\Users\CampaignService;
use App\Traits\GuestAuthTrait;
use Illuminate\Support\Facades\Auth;

class MoveController extends Controller
{
    /**
     * Guest Auth Trait
     */
    use GuestAuthTrait;

    public function __construct(
        protected MoveService $service,
        protected EntityTypeService $entityTypeService,
        protected CampaignService $campaignService,
    ) {
        $this->middleware(['auth']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authorize('view', $entity);

        $campaigns = $this->campaignService
            ->user(auth()->user())
            ->campaign($campaign)
            ->campaigns();

        return view('entities.pages.move.index', compact(
            'campaign',
            'entity',
            'campaigns',
        ));
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function move(MoveEntityRequest $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('view', $entity);
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $copied = $request->filled('copy');
        try {
            $this->service
                ->entity($entity)
                ->campaign($campaign)
                ->user($request->user())
                ->to($request->get('campaign'))
                ->copy($copied)
                ->validate()
                ->process();

            return redirect()
                ->route($entity->entityType->isSpecial() ? 'entities.index' : $entity->entityType->pluralCode() . '.index', [$campaign, $entity->entityType])
                ->with('success_raw', __('entities/move.success' . ($copied ? '_copy' : null), ['name' => $entity->name, 'campaign' => '<a href=\'' . route('dashboard', $this->service->target()) . '\'>' . $this->service->target()->name . '</a>']));
        } catch (TranslatableException $ex) {
            return redirect()
                ->to($entity->url())
                ->with('error_raw', $ex->getTranslatedMessage());
        }
    }
}
