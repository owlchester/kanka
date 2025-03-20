<?php

namespace App\Facades;

use App\Services\ImagesService;
use Illuminate\Support\Facades\Facade;

/**
 * Class Img
 *
 * @see ImagesService
 *
 * @mixin ImagesService
 */
class Images extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'images';
    }
}
