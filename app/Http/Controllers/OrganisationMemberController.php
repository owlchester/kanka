<?php

namespace App\Http\Controllers;

use App\Facades\CampaignLocalization;
use App\Models\Campaign;
use App\Models\Organisation;
use App\Models\OrganisationMember;
use App\Http\Requests\StoreOrganisationMember;

class OrganisationMemberController extends Controller
{
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

    /**
     * Show the form for creating a new resource.
     */
    public function create(Campaign $campaign, Organisation $organisation)
    {
        $this->authorize('member', $organisation);

        return view($this->view . '.create', [
            'campaign' => $campaign,
            'model' => $organisation,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrganisationMember $request, Campaign $campaign, Organisation $organisation)
    {
        $this->authorize('member', $organisation);

        $relation = OrganisationMember::create($request->all());
        return redirect()->route('organisations.show', $organisation->id)
            ->with('success', trans($this->view . '.create.success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign, Organisation $organisation, OrganisationMember $organisationMember)
    {
        $this->authorize('member', $organisation);

        return view($this->view . '.show', [
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
        if ($organisationMember->organisation_id !== $organisation->id) {
            abort(404);
        }

        return view($this->view . '.edit', [
            'campaign' => $campaign,
            'model' => $organisation,
            'member' => $organisationMember,
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
        if ($organisationMember->organisation_id !== $organisation->id) {
            abort(404);
        }

        $organisationMember->update($request->all());
        return redirect()->route('organisations.show', $organisation->id)
            ->with('success', trans($this->view . '.edit.success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign, Organisation $organisation, OrganisationMember $organisationMember)
    {
        $this->authorize('member', $organisation);
        if ($organisationMember->organisation_id !== $organisation->id) {
            abort(404);
        }

        $organisationMember->delete();
        return redirect()->route('organisations.show', $organisationMember->organisation_id)
            ->with('success', trans($this->view . '.destroy.success'));
    }
}
