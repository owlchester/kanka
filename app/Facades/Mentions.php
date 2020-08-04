<?php


namespace App\Facades;


use App\Models\Attribute;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityNote;
use App\Models\MiscModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;

/**
 * Class Mentions
 * @package App\Facades
 *
 * @method static map(MiscModel $model, string $field = 'entry')
 * @method static mapEntityNote(EntityNote $entityNote)
 * @method static mapAttribute(Attribute $attribute)
 * @method static mapCampaign(Campaign $campaign, string $field = 'entry')
 * @method static mapEntity(Entity $entity, string $field = 'tooltip')
 * @method static mapAny(Model $model, string $field = 'entry')
 * @method static edit(Entity $entity, string $field = 'entry'): string
 * @method static editEntityNote(EntityNote $entityNote, string $field = 'entry'): string
 * @method static editMisc(MiscModel $model, string $field = 'entry'): string
 * @method static editCampaign(Campaign $campaign, string $field = 'entry'): string
 * @method static editAny(Model $model, string $field = 'entry'): string
 * @method static codify(string $text): string
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
