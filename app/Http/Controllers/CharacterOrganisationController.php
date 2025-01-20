<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Character;
use App\Models\CharacterOrganisation;
use App\Models\OrganisationMember;
use App\Http\Requests\StoreOrganisationMember;

class CharacterOrganisationController extends Controller
{
    /**
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
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Campaign $campaign, Character $character)
    {
        return redirect()->to($character->getLink());
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Campaign $campaign, Character $character)
    {
        $this->authorize('update', $character->entity);

        return view($this->view . '.create', ['model' => $character, 'campaign' => $campaign]);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreOrganisationMember $request, Campaign $campaign, Character $character)
    {
        $this->authorize('update', $character->entity);
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $relation = OrganisationMember::create($request->all());
        return redirect()->route('characters.organisations', [$campaign, $character->id])
            ->with('success', __($this->view . '.create.success', [
                'character' => $character->name,
                'organisation' => $relation->organisation->name
            ]));
    }

    /**
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Campaign $campaign, Character $character, OrganisationMember $organisationMember)
    {
        $this->authorize('update', $character->entity);
        abort(404);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Campaign $campaign, Character $character, CharacterOrganisation $characterOrganisation)
    {
        $this->authorize('update', $character->entity);

        return view($this->view . '.edit', [
            'model' => $character,
            'campaign' => $campaign,
            'member' => $characterOrganisation,
        ]);
    }

    public function update(
        StoreOrganisationMember $request,
        Campaign $campaign,
        Character $character,
        CharacterOrganisation $characterOrganisation
    ) {
        $this->authorize('update', $character->entity);
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $characterOrganisation->update($request->all());

        if ($request->has('from') && $request->get('from') == 'org') {
            return redirect()->route('entities.show', [$campaign, $characterOrganisation->organisation->entity])
                ->with('success', __($this->view . '.edit.success'));
        }
        return redirect()->route('characters.organisations', [$campaign, $character->id])
            ->with('success', __($this->view . '.edit.success'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function destroy(Campaign $campaign, Character $character, CharacterOrganisation $characterOrganisation)
    {
        $this->authorize('update', $character->entity);

        $characterOrganisation->delete();

        if (request()->has('from') && request()->get('from') === 'org') {
            return redirect()->route('entities.show', [$campaign, $characterOrganisation->organisation->entity])
                ->with('success', __($this->view . '.destroy.success'));
        }

        return redirect()->route('characters.organisations', [$campaign, $characterOrganisation->character_id])
            ->with('success', __($this->view . '.destroy.success'));
    }
}
