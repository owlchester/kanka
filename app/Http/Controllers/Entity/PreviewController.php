<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Entity\PreviewService;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class PreviewController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function __construct(protected PreviewService $service) {}

    public function index(Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authEntityView($entity);

        return response()->json(
            $this
                ->service
                ->entity($entity)
                ->campaign($campaign)
                ->preview()
        );
    }
}
