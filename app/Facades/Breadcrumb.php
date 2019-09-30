<?php


namespace App\Facades;


use App\Models\Campaign;
use App\Models\EntityNote;
use App\Models\MiscModel;
use Illuminate\Support\Facades\Facade;

/**
 * Class Breadcrumb
 * @package App\Facades
 *
 * @method static index(string $name): string
 *
 * @see \App\Services\BreadcrumService
 */
class Breadcrumb extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'breadcrumb';
    }
}
