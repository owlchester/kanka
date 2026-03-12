<?php

namespace App\Http\Controllers\Characters;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCharacterOrganisation;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\CharacterOrganisation;
use App\Models\OrganisationMember;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class MembershipController extends Controller
{
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
     * @return RedirectResponse
     */
    public function index(Campaign $campaign, Character $character)
    {
        return redirect()->route('entities.show', [$campaign, $character->entity]);
    }

    /**
     * @return Application|Factory|View
     *
     * @throws AuthorizationException
     */
    public function create(Campaign $campaign, Character $character)
    {
        $this->authorize('update', $character->entity);

        return view($this->view . '.create', ['model' => $character, 'campaign' => $campaign]);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(StoreCharacterOrganisation $request, Campaign $campaign, Character $character)
    {
        $this->authorize('update', $character->entity);
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $relation = OrganisationMember::create(['character_id' => $character->id] + $request->all());

        return redirect()->route('characters.organisations', [$campaign, $character->id])
            ->with('success', __($this->view . '.create.success', [
                'character' => $character->name,
                'organisation' => $relation->organisation->name,
            ]));
    }

    /**
     * @return void
     *
     * @throws AuthorizationException
     */
    public function show(Campaign $campaign, Character $character, OrganisationMember $organisationMember)
    {
        $this->authorize('update', $character->entity);
        abort(404);
    }

    /**
     * @return Application|Factory|View
     *
     * @throws AuthorizationException
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
        StoreCharacterOrganisation $request,
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
     * @return RedirectResponse
     *
     * @throws AuthorizationException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
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
