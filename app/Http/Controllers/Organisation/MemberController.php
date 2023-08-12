<?php

namespace App\Http\Controllers\Organisation;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrganisationMember;
use App\Models\Campaign;
use App\Models\CampaignPermission;
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
     * @var string
     */
    protected string $view = 'organisations.members';

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

    public function index(Campaign $campaign, Organisation $organisation)
    {
        if (auth()->check()) {
            $this->authorize('view', $organisation);
        } else {
            $this->authorizeForGuest(CampaignPermission::ACTION_READ, $organisation, $organisation->entity->type_id);
        }

        $options = ['campaign' => $campaign, 'organisation' => $organisation];
        $base = 'members';
        if (request()->has('all')) {
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
                'parent', 'parent.character',
                'character', 'character.entity', 'character.entity.image',
                'character.location', 'character.location.entity'])
            ->has('character')
            ->has('character.entity')
            ->leftJoin('characters as c', 'c.id', 'organisation_member.character_id')
            ->sort(request()->only(['o', 'k']), ['c.name' => 'asc'])
            ->paginate(15);

        // Ajax Datagrid
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
    public function store(StoreOrganisationMember $request, Campaign $campaign, Organisation $organisation)
    {
        $this->authorize('member', $organisation);

        $relation = OrganisationMember::create($request->all());
        return redirect()->route('organisations.show', [$campaign, $organisation->id])
            ->with('success', trans($this->view . '.create.success'));
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

        $organisationMember->update($request->all());
        return redirect()->route('organisations.show', [$campaign, $organisation->id])
            ->with('success', trans($this->view . '.edit.success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign, Organisation $organisation, OrganisationMember $organisationMember)
    {
        $this->authorize('member', $organisation);

        $organisationMember->delete();
        return redirect()->route('organisations.show', [$campaign, $organisationMember->organisation_id])
            ->with('success', trans($this->view . '.destroy.success'));
    }
}
