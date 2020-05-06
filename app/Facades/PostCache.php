<?php

namespace App\Facades;

use App\Models\Release;
use Illuminate\Support\Facades\Facade;

/**
 * Class PostCache
 * @package App\Facades
 *
 * @method static null|Release latest()
 * @method static bool clearLatest()
 */
class PostCache extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'postcache';
    }
}
