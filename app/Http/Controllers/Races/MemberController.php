<?php

namespace App\Http\Controllers\Races;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Race;
use App\Http\Requests\StoreCharacterRace;
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

    public function index(Campaign $campaign, Race $race)
    {
        $this->campaign($campaign)->authView($race);

        $options = ['campaign' => $campaign, 'race' => $race];
        $filters = [];
        $relation = 'allCharacters';
        if (request()->has('race_id')) {
            $options['race_id'] = (int) request()->get('race_id');
            $filters['race_id'] = $options['race_id'];
            $relation = 'characters';
        }
        Datagrid::layout(\App\Renderers\Layouts\Race\Character::class)
            ->route('races.characters', $options);

        $this->rows = $race
            ->{$relation}()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->filter($filters)
            ->with([
                'location', 'location.entity',
                'families', 'families.entity',
                'races', 'races.entity',
                'entity', 'entity.tags', 'entity.image', 'entity.tags.entity'
            ])
            ->has('entity')
            ->paginate(15);

        return $this->campaign($campaign)->datagridAjax();
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Campaign $campaign, Race $race)
    {
        $this->authorize('update', $race);

        return view('races.members.create', [
            'campaign' => $campaign,
            'model' => $race,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCharacterRace $request, Campaign $campaign, Race $race)
    {
        $this->authorize('update', $race);

        $newMembers = $race->characters()->syncWithoutDetaching($request->members);

        return redirect()->route('entities.show', [$campaign, $race->entity])
            ->with('success', trans_choice('races.members.create.success', count($newMembers['attached']), ['count' => count($newMembers['attached'])]));
    }
}
