<?php


namespace App\Http\Controllers\Entity;


use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Traits\GuestAuthTrait;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use GuestAuthTrait;

    public function index(Entity $entity)
    {
        if (Auth::check()) {
            $this->authorize('view', $entity->child);
        } else {
            $this->authorizeEntityForGuest(\App\Models\CampaignPermission::ACTION_READ, $entity->child);
        }

        return view('entities.pages.profile.index')
            ->with('entity', $entity)
            ->with('model', $entity->child);
    }
}
