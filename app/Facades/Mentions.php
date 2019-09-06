<?php


namespace App\Facades;


use App\Models\Campaign;
use App\Models\EntityNote;
use App\Models\MiscModel;
use Illuminate\Support\Facades\Facade;

/**
 * Class Mentions
 * @package App\Facades
 *
 * @method static map(MiscModel $model, string $field = 'entry')
 * @method static mapEntityNote(EntityNote $entityNote)
 * @method static mapCampaign(Campaign $campaign, string $field = 'entry')
 *
 * @see \App\Services\MentionsService
 */
class Mentions extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'mentions';
    }
}
