<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class ShowController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function index(Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authEntityView($entity);
        ;
        /*if ($entity->slug !== $slug) {
            return redirect()->route('entities.show', [$campaign, $entity, $entity->slug]);
        }*/


        return view('cruds.show')
            ->with('campaign', $campaign)
            ->with('entity', $entity)
        ;
    }
}
