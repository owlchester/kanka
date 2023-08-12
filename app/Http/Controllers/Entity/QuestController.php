<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Traits\GuestAuthTrait;
use Illuminate\Support\Facades\Auth;

class QuestController extends Controller
{
    /**
     * Guest Auth Trait
     */
    use GuestAuthTrait;

    /**
     */
    public function index(Campaign $campaign, Entity $entity)
    {
        if (empty($entity->child)) {
            abort(404);
        }

        // Policies will always fail if they can't resolve the user.
        if (Auth::check()) {
            $this->authorize('view', $entity->child);
        } else {
            $this->authorizeEntityForGuest(\App\Models\CampaignPermission::ACTION_READ, $entity->child);
        }

        $quests = $entity
            ->quests()
            ->with(['quest', 'quest.entity'])
            ->has('quest')
            ->paginate();

        return view('entities.pages.quests.index', compact(
            'entity',
            'quests',
        ));
    }
}
