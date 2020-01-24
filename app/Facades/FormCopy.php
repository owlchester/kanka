<?php


namespace App\Facades;


use App\Models\MiscModel;
use App\Services\FormCopyService;
use Illuminate\Support\Facades\Facade;

/**
 * Class FormCopy
 * @package App\Facades
 *
 * @method static source(MiscModel $source = null): self
 * @method static field(string $field): self
 * @method static entity(): self
 * @method static string(string $default = ''): string
 * @method static select(bool $checkForParent = false, string $parentClass = null)
 * @method static boolean(bool $default = false): bool
 * @method static colours(bool $withNull = true): array
 *
 * @see FormCopyService
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
