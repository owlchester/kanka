<?php


namespace App\Facades;


use App\Models\Attribute;
use App\Models\Entity;
use App\Services\AttributeService;
use Illuminate\Support\Facades\Facade;

/**
 * Class Img
 * @package App\Facades
 *
 * @see AttributeService
 * @mixin AttributeService
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
{

}
