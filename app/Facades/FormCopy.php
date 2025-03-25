<?php

namespace App\Facades;

use App\Services\FormCopyService;
use Illuminate\Support\Facades\Facade;

/**
 * Class FormCopy
 *
 * @see FormCopyService
 *
 * @mixin \App\Services\FormCopyService
 */
class FormCopy extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return FormCopyService::class;
    }
}
