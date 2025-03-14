<?php

namespace App\Http\Controllers\Organisation;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrganisationMember;
use App\Http\Requests\StoreOrganisationMembers;
use App\Models\Campaign;
use App\Models\Organisation;
use App\Models\OrganisationMember;
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

    /**
     */
    protected string $view = 'organisations.members';

    public function index(Campaign $campaign, Organisation $organisation)
    {
        $this->campaign($campaign)->authEntityView($organisation->entity);

        $options = ['campaign' => $campaign, 'organisation' => $organisation];
        $base = 'members';
        if ($this->filterToAll()) {
            $options['all'] = true;
            $base = 'allMembers';
        }
        Datagrid::layout(\App\Renderers\Layouts\Organisation\Member::class)
            ->route('organisations.members', $options)
            ->actionParams(['from' => 'org']);

        $this->rows = $organisation
            ->{$base}()
            ->select('organisation_member.*')
            ->with([
                'organisation', 'organisation.entity',
                'organisation.entity.entityType' => function ($sub) {
                    $sub->select('id', 'code');
                },
                'parent', 'parent.character', 'parent.character.entity',
                'character', 'character.entity', 'character.entity.image',
                'character.entity.entityType' => function ($sub) {
                    $sub->select('id', 'code');
                },
                'character.location', 'character.location.entity'])
            ->has('character')
            ->has('character.entity')
            ->leftJoin('characters as c', 'c.id', 'organisation_member.character_id')
            ->sort(request()->only(['o', 'k']), ['c.name' => 'asc'])
            ->paginate(config('limits.pagination'));

        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }
        return $this
            ->campaign($campaign)
            ->subview('organisations.members', $organisation);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Campaign $campaign, Organisation $organisation)
    {
        $this->authorize('member', $organisation);

        return view($this->view . '.create', [
            'model' => $organisation,
            'campaign' => $campaign
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrganisationMembers $request, Campaign $campaign, Organisation $organisation)
    {
        $this->authorize('member', $organisation);
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        $count = 0;
        foreach ($request->get('characters', []) as $character) {
            $relation = OrganisationMember::create(['character_id' => $character] + $request->except('characters'));
            $count++;
        }
        return redirect()->route('entities.show', [$campaign, $organisation->entity])
            ->with('success', trans_choice($this->view . '.create.success_multiple', $count, ['name' => $organisation->name, 'count' => $count]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign, Organisation $organisation, OrganisationMember $organisationMember)
    {
        $this->authorize('member', $organisation);

        return view($this->view . '.show', [
            'campaign' => $campaign,
            'model' => $organisation,
            'member' => $organisationMember
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign, Organisation $organisation, OrganisationMember $organisationMember)
    {
        $this->authorize('member', $organisation);

        return view($this->view . '.edit', [
            'model' => $organisation,
            'member' => $organisationMember,
            'campaign' => $campaign
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        StoreOrganisationMember $request,
        Campaign $campaign,
        Organisation $organisation,
        OrganisationMember $organisationMember
    ) {
        $this->authorize('member', $organisation);
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        $organisationMember->update($request->all());
        return redirect()->route('entities.show', [$campaign, $organisation->entity])
            ->with('success', trans($this->view . '.edit.success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign, Organisation $organisation, OrganisationMember $organisationMember)
    {
        $this->authorize('member', $organisation);

        $organisationMember->delete();
        return redirect()->route('entities.show', [$campaign, $organisationMember->organisation->entity])
            ->with('success', trans($this->view . '.destroy.success'));
    }
}
