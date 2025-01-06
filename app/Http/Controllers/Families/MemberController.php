<?php

namespace App\Http\Controllers\Families;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCharacterFamily;
use App\Models\Campaign;
use App\Models\Family;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;

class MemberController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    public function index(Campaign $campaign, Family $family)
    {
        $this->campaign($campaign)->authEntityView($family->entity);

        $options = ['campaign' => $campaign, 'family' => $family, 'm' => $this->descendantsMode()];
        $relation = 'allMembers';
        if ($this->filterToDirect()) {
            $relation = 'members';
        }
        Datagrid::layout(\App\Renderers\Layouts\Family\Character::class)
            ->route('families.members', $options)
        ;

        $this->rows = $family
            ->{$relation}()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->with([
                'location', 'location.entity',
                'characterFamilies',
                'entity', 'entity.tags', 'entity.tags.entity', 'entity.image'
            ])
            ->has('entity')
            ->paginate();

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }
        return $this
            ->campaign($campaign)
            ->subview('families.members', $family);
    }

    public function create(Campaign $campaign, Family $family)
    {
        $this->authorize('update', $family);

        return view('families.members.create', [
            'campaign' => $campaign,
            'model' => $family,
        ]);
    }

    public function store(StoreCharacterFamily $request, Campaign $campaign, Family $family)
    {
        $this->authorize('update', $family);
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        $newMembers = $family->members()->syncWithoutDetaching($request->members);

        return redirect()->route('entities.show', [$campaign, $family->entity])
            ->with('success', trans_choice('families.members.create.success', count($newMembers['attached']), ['count' => count($newMembers['attached'])]));
    }
}
