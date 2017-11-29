<?php

namespace App\Observers;

use App\Campaign;
use App\Item;
use App\Services\ImageService;
use App\Services\LinkerService;
use Illuminate\Support\Facades\Session;

class ItemObserver
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
     * @param Item $item
     */
    public function saving(Item $item)
    {
        $item->slug = str_slug($item->name, '');
        $item->campaign_id = Session::get('campaign_id');

        // Purity text
        $item->history = $this->purify($item->history);
        $item->description = $this->purify($item->description);

        // Parse links
        $item->history = $this->linkerService->parse($item->history);
        $item->description = $this->linkerService->parse($item->description);

        // Handle image. Let's use a service for this.
        ImageService::handle($item, 'items');

        $nullable = ['location_id', 'character_id'];
        foreach ($nullable as $attr) {
            $item->setAttribute($attr, (request()->has($attr) ? request()->post($attr) : null));
        }
    }

    /**
     * @param Item $item
     */
    public function saved(Item $item)
    {
    }

    /**
     * @param Item $item
     */
    public function created(Item $item)
    {
    }

    /**
     * @param Item $item
     */
    public function deleted(Item $item)
    {
        ImageService::cleanup($item);
    }

    /**
     * @param Item $item
     */
    public function deleting(Item $item)
    {
        /*foreach ($item->members as $character) {
            $character->family_id = null;
            $character->save();
        }*/
    }
}
