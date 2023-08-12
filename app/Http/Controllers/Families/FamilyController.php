<?php

namespace App\Http\Controllers\Families;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\Family;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;

class FamilyController extends Controller
{
    use CampaignAware;
    use HasDatagrid;
    use HasSubview;
    use GuestAuthTrait;

    /**
     * @var string
     */
    protected string $view = 'families.members';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('campaign.member');
    }

    public function index(Campaign $campaign, Family $family)
    {
        if (auth()->check()) {
            $this->authorize('view', $family);
        } else {
            $this->authorizeForGuest(CampaignPermission::ACTION_READ, $family, $family->entity->type_id);
        }

        $options = ['campaign' => $campaign, 'family' => $family];
        $filters = [];
        if (request()->has('parent_id')) {
            $options['parent_id'] = $family->id;
            $filters['parent'] = $family->id;
        }
        Datagrid::layout(\App\Renderers\Layouts\Family\Family::class)
            ->route('families.families', $options)
        ;

        $this->rows = $family
            ->descendants()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->filter($filters)
            ->with(['location', 'location.entity', 'entity', 'entity.tags'])
            ->paginate(15);

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }
        return $this
            ->campaign($campaign)
            ->subview('families.families', $family);
    }
}
