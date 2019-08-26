<?php


namespace App\Facades;


use App\Models\MiscModel;
use Illuminate\Support\Facades\Facade;

/**
 * Class Mentions
 * @package App\Facades
 *
 * @method static map(MiscModel $model, string $field = 'entry')
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
