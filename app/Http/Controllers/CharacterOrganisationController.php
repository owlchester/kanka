<?php

namespace App\Http\Controllers;

use App\Facades\CampaignLocalization;
use App\Models\Character;
use App\Models\CharacterOrganisation;
use App\Models\OrganisationMember;
use App\Http\Requests\StoreOrganisationMember;

class CharacterOrganisationController extends Controller
{
    /**
     * @var string
     */
    protected string $view = 'characters.organisations';

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
     * @param Character $character
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Character $character)
    {
        return redirect()->route('characters.show', $character);
    }

    /**
     * @param Character $character
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Character $character)
    {
        $this->authorize('organisation', [$character, 'add']);
        $ajax = request()->ajax();

        return view($this->view . '.' . ($ajax ? '_' : null) . 'create', ['model' => $character, 'ajax' => $ajax]);
    }

    /**
     * @param StoreOrganisationMember $request
     * @param Character $character
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreOrganisationMember $request, Character $character)
    {
        $this->authorize('organisation', [$character, 'add']);

        $relation = OrganisationMember::create($request->all());
        return redirect()->route('characters.organisations', [$character->id])
            ->with('success', __($this->view . '.create.success'));
    }

    /**
     * @param Character $character
     * @param OrganisationMember $organisationMember
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Character $character, OrganisationMember $organisationMember)
    {
        $this->authorize('organisation', [$character, 'read']);

        dd('wut');
    }

    /**
     * @param Character $character
     * @param CharacterOrganisation $characterOrganisation
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Character $character, CharacterOrganisation $characterOrganisation)
    {
        $this->authorize('organisation', [$character, 'edit']);
        if ($character->id !== $characterOrganisation->character_id) {
            abort(404);
        }
        $ajax = request()->ajax();
        $campaign = CampaignLocalization::getCampaign();

        return view($this->view . '.' . ($ajax ? '_' : null) . 'edit', [
            'campaign' => $campaign,
            'model' => $character,
            'member' => $characterOrganisation,
            'ajax' => $ajax
        ]);
    }

    /**
     * @param StoreOrganisationMember $request
     * @param Character $character
     * @param CharacterOrganisation $characterOrganisation
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(
        StoreOrganisationMember $request,
        Character $character,
        CharacterOrganisation $characterOrganisation
    ) {
        $this->authorize('organisation', [$character, 'edit']);
        if ($character->id !== $characterOrganisation->character_id) {
            abort(404);
        }

        $characterOrganisation->update($request->all());


        if ($request->has('from') && $request->get('from') == 'org') {
            return redirect()->route('organisations.show', [$characterOrganisation->organisation_id])
                ->with('success', __($this->view . '.edit.success'));
        }
        return redirect()->route('characters.organisations', [$character->id])
            ->with('success', __($this->view . '.edit.success'));
    }

    /**
     * @param Character $character
     * @param CharacterOrganisation $characterOrganisation
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function destroy(Character $character, CharacterOrganisation $characterOrganisation)
    {
        $this->authorize('organisation', [$character, 'delete']);
        if ($character->id !== $characterOrganisation->character_id) {
            abort(404);
        }

        $characterOrganisation->delete();

        if (request()->has('from') && request()->get('from') === 'org') {
            return redirect()->route('organisations.show', [$characterOrganisation->organisation_id])
                ->with('success', __($this->view . '.destroy.success'));
        }

        return redirect()->route('characters.organisations', [$characterOrganisation->character_id])
            ->with('success', __($this->view . '.destroy.success'));
    }
}
