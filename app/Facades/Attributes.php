<?php

namespace App\Facades;

use App\Services\AttributeMentionService;
use Illuminate\Support\Facades\Facade;

/**
 * Class Attributes
 *
 * @see AttributeMentionService
 *
 * @mixin AttributeMentionService
 */
class Attributes extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'attributes';
    }
}
