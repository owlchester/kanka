<?php

namespace App\Facades;

use App\Services\ImgService;
use Illuminate\Support\Facades\Facade;

/**
 * Class Img
 *
 * @see ImgService
 *
 * @mixin ImgService
 */
class Img extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'img';
    }
}
