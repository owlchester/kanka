<?php

namespace App\Http\Controllers\Characters\Families;

use App\Http\Controllers\Controller;
use App\Http\Requests\ManageFamilies;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\CharacterFamily;
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

        $families = $character
            ->characterFamilies()
            ->with(['family', 'family.entity', 'family.entity.image'])
            ->get();

        return view('characters.families.reorder', compact(
            'campaign',
            'families',
            'character'
        ));
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function save(Campaign $campaign, Character $character, ManageFamilies $request)
    {
        $this->authorize('update', $character->entity);

        $families = $character->families()->pluck('families.id')->toArray();
        $privates = $request->get('family_privates');

        // We need to delete the old ones to make way for the new ones.
        CharacterFamily::where('character_id', $character->id)->delete();
        foreach ($request->get('character_family') as $newFamily) {
            // We just want to reorder, not add whatever the user sends as a request.
            if (in_array($newFamily, $families)) {
                $characterFamily = new CharacterFamily;
                $characterFamily->family_id = $newFamily;
                $characterFamily->character_id = $character->id;
                $characterFamily->is_private = $privates[$newFamily];
                $characterFamily->save();
            }
        }

        return redirect()
            ->route('entities.show', [$campaign, $character->entity])
            ->withSuccess(__('characters.families.reorder.success', ['name' => $character->name]));
    }
}
