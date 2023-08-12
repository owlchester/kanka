<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authEntityView($entity);

        // @phpstan-ignore-next-line
        if (!view()->exists('entities.pages.profile._' . $entity->type())) {
            return redirect()->to($entity->url());
        }

        return view('entities.pages.profile.index')
            ->with('campaign', $campaign)
            ->with('entity', $entity)
            ->with('model', $entity->child);
    }
}
