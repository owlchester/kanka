<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveAttributes;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Attributes\EntitySheetService;
use App\Services\AttributeService;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;
use Illuminate\Support\Facades\DB;

/**
 * Attribute Controller
 */
class AttributeController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function __construct(protected AttributeService $service, protected EntitySheetService $sheetService) {}

    public function index(Campaign $campaign, Entity $entity)
    {
        if (! $campaign->enabled('entity_attributes')) {
            return redirect()->route('entities.show', [$campaign, $entity])->with(
                'error_raw',
                __('campaigns.settings.errors.module-disabled', [
                    'fix' => '<a href="' . route('campaign.modules', [$campaign, '#entity_attributes']) . '" class="text-link">' . __('crud.fix-this-issue') . '</a>',
                ])
            );
        }

        $this->campaign($campaign)->authEntityView($entity);
        $this->authorize('view-attributes', [$entity, $campaign]);

        return view('entities.pages.attributes.index', compact('entity', 'campaign'));
    }

    public function dashboard(Campaign $campaign, Entity $entity)
    {
        if (! $campaign->enabled('entity_attributes')) {
            return redirect()->route('dashboard', $campaign)->with(
                'error_raw',
                __('campaigns.settings.errors.module-disabled', [
                    'fix' => '<a href="' . route('campaign.modules', [$campaign, '#entity_attributes']) . '" class="text-link">' . __('crud.fix-this-issue') . '</a>',
                ])
            );
        }
        $this->campaign($campaign)->authEntityView($entity);
        $this->authorize('view-attributes', [$entity, $campaign]);

        $fromDashboard = true;

        return view('entities.pages.attributes.dashboard', compact(
            'entity',
            'campaign',
            'fromDashboard'
        ));
    }

    public function edit(Campaign $campaign, Entity $entity)
    {
        if (! $campaign->enabled('entity_attributes')) {
            return redirect()->route('dashboard', $campaign)->with(
                'error_raw',
                __('campaigns.settings.errors.module-disabled', [
                    'fix' => '<a href="' . route('campaign.modules', [$campaign, '#entity_attributes']) . '" class="text-link">' . __('crud.fix-this-issue') . '</a>',
                ])
            );
        }
        if ($entity->isMissingChild()) {
            abort(404);
        }
        $this->authorize('update', $entity);
        $this->authorize('attributes', $entity);

        return view('entities.pages.attributes.edit', compact(
            'campaign',
            'entity',
        ));
    }

    public function save(SaveAttributes $request, Campaign $campaign, Entity $entity)
    {
        if ($entity->isMissingChild()) {
            abort(404);
        }
        $this->authorize('update', $entity);
        $this->authorize('attributes', $entity);

        $attributes = $request->get('attribute', []);
        DB::transaction(function () use ($request, $entity, $campaign, $attributes): void {
            if ($request->has('sheets_present')) {
                $this->sheetService->sync($entity, $campaign, $request->input('sheets', []));
            }
            $this->service
                ->entity($entity)
                ->campaign($campaign)
                ->user($request->user())
                ->updateVisibility(request()->get('is_attributes_private') === '1')
                ->save($attributes)
                ->touch();
        });

        return redirect()->route('entities.attributes', [$campaign, $entity->id])
            ->with('success', __('entities/attributes.update.success', ['entity' => $entity->name]));
    }

    public function liveEdit(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity);

        $id = request()->get('id');
        $uid = request()->get('uid');
        if (! is_numeric($uid)) {
            abort(421);
        }

        $attribute = $entity->attributes()->where('id', $id)->first();
        if (! $id || ! $attribute) {
            return abort(421);
        }

        return response()->view('entities.pages.attributes.live.edit', compact('campaign', 'attribute', 'entity', 'uid'));
    }
}
