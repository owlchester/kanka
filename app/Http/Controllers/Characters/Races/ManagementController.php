<?php

namespace App\Http\Controllers\Characters\Races;

use App\Http\Controllers\Controller;
use App\Http\Requests\ManageRaces;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\CharacterRace;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;

class ManagementController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    public function index(Campaign $campaign, Character $character)
    {
        $this->authorize('update', $character->entity);

        $this->campaign($campaign)->authEntityView($character->entity);

        $races = $character
            ->characterRaces()
            ->with(['race', 'race.entity', 'race.entity.image'])
            ->get();

        return view('characters.races.reorder', compact(
            'campaign',
            'races',
            'character'
        ));
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function save(Campaign $campaign, Character $character, ManageRaces $request)
    {
        $this->authorize('update', $character->entity);

        $races = $character->races()->pluck('races.id')->toArray();
        $privates = $request->get('race_privates');

        // We need to delete the old ones to make way for the new ones.
        CharacterRace::where('character_id', $character->id)->delete();
        foreach ($request->get('character_race') as $newRace) {
            // We just want to reorder, not add whatever the user sends as a request.
            if (in_array($newRace, $races)) {
                $characterRace = new CharacterRace;
                $characterRace->race_id = $newRace;
                $characterRace->character_id = $character->id;
                $characterRace->is_private = $privates[$newRace];
                $characterRace->save();
            }
        }

        return redirect()
            ->route('entities.show', [$campaign, $character->entity])
            ->withSuccess(__('characters.races.reorder.success', ['name' => $character->name]));
    }
}
