<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class ProfileController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function index(Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authEntityView($entity);

        if (!view()->exists('entities.pages.profile._' . $entity->entityType->code)) {
            return redirect()->to($entity->url());
        }

        return view('entities.pages.profile.index')
            ->with('campaign', $campaign)
            ->with('entity', $entity)
            ->with('model', $entity->child);
    }
}
