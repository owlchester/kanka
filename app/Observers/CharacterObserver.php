<?php

namespace App\Observers;

use App\Campaign;
use App\Models\Character;
use App\Services\ImageService;
use App\Services\LinkerService;
use Illuminate\Support\Facades\Session;

class CharacterObserver
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
     * @param Character $character
     */
    public function saving(Character $character)
    {
        $character->slug = str_slug($character->name, '');
        $character->campaign_id = Session::get('campaign_id');

        // Purity text
        $character->history = $this->purify($character->history);

        // Parse links
        $character->history = $this->linkerService->parse($character->history);

        // Handle image. Let's use a service for this.
        ImageService::handle($character, 'characters');

        $nullable = ['location_id', 'family_id'];
        foreach ($nullable as $attr) {
            $character->setAttribute($attr, (request()->has($attr) ? request()->post($attr) : null));
        }
    }

    /**
     * @param Character $character
     */
    public function saved(Character $character)
    {
    }

    /**
     * @param Character $character
     */
    public function created(Character $character)
    {
    }

    /**
     * @param Character $character
     */
    public function deleted(Character $character)
    {
        ImageService::cleanup($character);
    }

    /**
     * @param Character $character
     */
    public function deleting(Character $character)
    {
        foreach ($character->items as $item) {
            $item->character_id = null;
            $item->save();
        }
    }
}
