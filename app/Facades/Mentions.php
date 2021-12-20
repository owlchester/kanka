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
 * @see \App\Services\MentionsService
 * @mixin \App\Services\MentionsService
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
