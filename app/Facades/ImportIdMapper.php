<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class QuestCache
 *
 * @see \App\Services\Campaign\Import\ImportIdMapper
 *
 * @mixin \App\Services\Campaign\Import\ImportIdMapper
 */
class ImportIdMapper extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'importidmapper';
    }
}
