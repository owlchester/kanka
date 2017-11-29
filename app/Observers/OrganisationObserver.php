<?php

namespace App\Observers;

use App\Campaign;
use App\Organisation;
use App\Services\ImageService;
use App\Services\LinkerService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrganisationObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

    /**
     * @var LinkerService
     */
    protected $linkerService;

    /**
     * CharacterObserver constructor.
     * @param LinkerService $linkerService
     */
    public function __construct(LinkerService $linkerService)
    {
        $this->linkerService = $linkerService;
    }

    /**
     * @param Organisation $organisation
     */
    public function saving(Organisation $organisation)
    {
        $organisation->slug = str_slug($organisation->name, '');
        $organisation->campaign_id = Session::get('campaign_id');

        // Purity text
        $organisation->history = $this->purify($organisation->history);

        // Parse links
        $organisation->history = $this->linkerService->parse($organisation->history);

        // Handle image. Let's use a service for this.
        ImageService::handle($organisation, 'organisations');

        $nullable = ['location_id'];
        foreach ($nullable as $attr) {
            $organisation->setAttribute($attr, (request()->has($attr) ? request()->post($attr) : null));
        }
    }

    /**
     * @param Character $character
     */
    public function deleted(Organisation $organisation)
    {
        ImageService::cleanup($organisation);
    }

    /**
     * @param Organisation $organisation
     */
    public function deleting(Organisation $organisation)
    {
        foreach ($organisation->members as $member) {
            $member->delete();
        }
    }
}
